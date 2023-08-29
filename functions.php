<?php
/**
 * @author func0der
 *
 * Please report bugs to the above contact places ;)
 */
function upgradeEmailAddress($email, $password, $single = true)
{
    if (empty($email) || empty($password)) {
        throw new Exception("Email and/or password cannot be empty");
    }

    // Get login token
    $url = 'https://lts.web.de/logintokenserver-1.0/Logintoken';
    $c = curl_init($url);

    curl_setopt($c, CURLOPT_POST, 1);
    curl_setopt($c, CURLOPT_NOBODY, 0);
    curl_setopt($c, CURLOPT_HEADER, 0);
    curl_setopt($c, CURLINFO_HEADER_OUT, 0);
    curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);

    $postData = [
        'identifierUrn' => 'urn:identifier:mailto:' . $email,
        'password' => $password,
        'durationType' => 'SHORT',
        'loginClientType' => 'toolbar',
    ];

    foreach ($postData as $field => $data) {
        $postData[] = $field . '=' . $data;
        unset($postData[$field]);
    }
    curl_setopt($c, CURLOPT_POSTFIELDS, (implode('&', $postData)));

    $header = [];
    $header[] = 'Accept: text/plain; charset=iso-8859-15';
    curl_setopt($c, CURLOPT_HTTPHEADER, $header);

    $result = curl_exec($c);
    curl_close($c);
    $token = trim($result);

    // If the token is 64bit long the request has been successful
    if (strlen($token) == 64) {
        unset($result);
        // Login and get next step url
        $url = 'https://uas2.uilogin.de/tokenlogin';
        $c = curl_init($url);

        curl_setopt($c, CURLOPT_POST, 1);
        curl_setopt($c, CURLOPT_NOBODY, 0);
        curl_setopt($c, CURLOPT_HEADER, 1);
        curl_setopt($c, CURLINFO_HEADER_OUT, 1);
        curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($c, CURLOPT_FOLLOWLOCATION, 0);
        curl_setopt($c, CURLOPT_MAXREDIRS, 10);

        $postData = [
            'logintoken' => 'urn:password:toolbartoken:' . $token,
            'serviceID' => 'pacs.toolbar.webde',
        ];

        foreach ($postData as $field => $data) {
            $postData[] = $field . '=' . $data;
            unset($postData[$field]);
        }
        curl_setopt($c, CURLOPT_POSTFIELDS, (implode('&', $postData)));

        $header = [];
        $header[] = "Accept : application/xml";
        $header[] = "X-UI-App : Firefox-Toolbar/1.7.1";
        curl_setopt($c, CURLOPT_HTTPHEADER, $header);

        $result = curl_exec($c);
        debug(curl_getinfo($c));
        debug($result);
        exitd();
        curl_close($c);
        // Get next step url out of the redirect
        if ($result) {
            $responseHeaders = explode("\r\n", $result);
            foreach ($responseHeaders as $header) {
                if (($pos = strpos($header, 'Location:')) !== FALSE) {
                    $location = trim(substr($header, ($pos + strlen('Location:'))));
                    break;
                }
            }
// DIRTY: Hack to get around the login fail
            $sessionCookie = substr(
                $location,
                strpos($location, 'jsessionid=') + strlen('jsessionid=')
            );

            unset($result);
            // Get session cookie and next step url
            $c = curl_init($location);
            $header = [];
            $header[] = "Accept : application/xml";
            $header[] = "X-UI-App : Firefox-Toolbar/1.7.1";
            // We need to fake user agent here
            // XXX: Seems like it is only important to have a user agent containing the application in "X-UI-App"
            curl_setopt($c, CURLOPT_USERAGENT, 'Mozilla/5.0 (Ubuntu; X11; Linux i686; rv:9.0.1) Gecko/20100101 Firefox/9.0.1');
            curl_setopt($c, CURLOPT_HTTPHEADER, $header);
            curl_setopt($c, CURLOPT_NOBODY, 0);
            curl_setopt($c, CURLOPT_HEADER, 1);
            curl_setopt($c, CURLINFO_HEADER_OUT, 1);
            curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($c, CURLOPT_FOLLOWLOCATION, 0);

            $result = curl_exec($c);
            curl_close($c);
            debug($location);
            debug($result);

            if ($result) {
                $result = explode("\r\n\r\n", $result);
                $resultHeaders = $result[0];
                $resultHeaders = explode("\r\n", $resultHeaders);
                foreach ($resultHeaders as $h) {
                    if (($pos = strpos($h, 'Set-Cookie:')) !== FALSE) {
// DIRTY: Hack to get around the login fail
                        //$sessionCookie = trim(substr($h, ($pos + strlen('Set-Cookie:'))));
                        break;
                    }
                }
                $result = $result[1];

                $xmlResponse = new DomDocument();
                $xmlResponse->loadXML($result);
                $mailCheckBaseURL = $xmlResponse->getElementsByTagName('mailServiceBaseURI')->item(0)->nodeValue;
                $mailCheckBaseURL = 'https://pacs.web.de/http-service-proxy1/service/msgsrv-webde-toolbar/Mailbox/primaryMailbox/';

                unset($result);
                // Call mail box to simulate an action coming from a logged in toolbar
                $url = $mailCheckBaseURL . 'FolderQuota?absoluteURI=false';
                $c = curl_init($url);
                $header = [];
                $header[] = 'Cookie: ' . $sessionCookie;
                $header[] = "Accept : application/xml";
                $header[] = "X-UI-App : Firefox-Toolbar/1.7.1";
                // Lets use firefox as user agent (see above for reasons)
                curl_setopt($c, CURLOPT_USERAGENT, 'Firefox');
                curl_setopt($c, CURLOPT_HTTPHEADER, $header);
                curl_setopt($c, CURLOPT_NOBODY, 0);
                curl_setopt($c, CURLOPT_HEADER, 0);
                curl_setopt($c, CURLINFO_HEADER_OUT, 1);
                curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($c, CURLOPT_FOLLOWLOCATION, 0);

                $result = curl_exec($c);
                curl_close($c);
                debug($result);
                exitd;
                if ($result) {
                    return true;
                } // end if ($result)
                else {
                    $message = "Either Web.de has changed its access points or some unknown problem occured.";
                    if ($single === true) {
                        throw new Exception($message);
                    } else {
                        return $message;
                    }
                } // end if ($result) else
            }
        }
    } // end if (strlen($token) == 64)
    else {
        $message = "Error while receiving token. Your account/password combination is either wrong, the account does not exist or is deactivated.";
        if ($single === true) {
            throw new Exception($message);
        } else {
            return $message;
        }
    } // end if (strlen($token) == 64) else
}

function upgradeEmailAddresses($addresses)
{
    $log = '';
    if (is_array($addresses)) {
        foreach ($addresses as $address => $password) {
            $log .= $address . ': ';
            // In case we have message as a return there is an error
            if (
                (
                $result = upgradeEmailAddress($address, $password, false)
                ) !== true
            ) {
                $log .= $result;
            } else {
                $log .= 'OK';
            }
            $log .= "\r\n";
        }
    }
    return $log;
}

function debug($var, $type = 0)
{
    if (checkIp()) {
        echo '<pre>';
        if ($type == 0) {
            var_dump($var);
        } else {
            print_r($var);
        }

        echo '</pre>';
    }
}

function exitd()
{
    if (checkip()) {
        exit;
    }
}

function checkIp()
{
    if ($_SERVER['REMOTE_ADDR'] == '[debuggerIp]') {
        return true;
    }
    return false;
}

?>
