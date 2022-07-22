<?php
require_once VENDOR_AUTOLOAD_PATH;

use PHPMailer\PHPMailer\PHPMailer;

class EmailSending
{
    private $mailer = null;
    private static $emissary = 'Unitrópico | Admisiones';

    private function initializePHPMailer()
    {
        $mailer = new PHPMailer(true);
        //Server settings
        $mailer->SMTPDebug = 0;                                        // Enable verbose debug output
        $mailer->isSMTP();                                             // Set mailer to use SMTP
        $mailer->Host = 'smtp.gmail.com';                              // Specify main and backup SMTP servers
        $mailer->SMTPAuth = true;                                      // Enable SMTP authentication
        $mailer->Username = 'sistemadeadmisiones@unitropico.edu.co';   // SMTP username
        $mailer->Password = '15082021nefferadmisiones';                // SMTP password
        $mailer->SMTPSecure = "TLS";                                   // Enable TLS encryption, `ssl` also accepted
        $mailer->Port = 587;                                           // TCP port to connect to
        $mailer->setFrom('sistemadeadmisiones@unitropico.edu.co', utf8_decode(self::$emissary));
        $mailer->isHTML(true);

        return $mailer;
    }

    public static function send($to, $subject, $content, $attachment = null)
    {
        $mailer = self::initializePHPMailer();

        if (isset($attachment)) $mailer->addAttachment($attachment);

        $mailer->Subject = utf8_decode($subject);
        $mailer->Body    = utf8_decode(self::generateEmailTemplate($content));

        try {
            $mailer->addAddress($to);
            $mailer->send();
        } catch (Exception $e) {
            return false;
        } finally {
            $mailer->clearAddresses();
            $mailer->clearAttachments();
        }

        return true;
    }

    public static function sendMassive($to, $subject, $content, $attachment)
    {
        $log = [];

        if (empty($to)) return $log;

        $mailer = self::initializePHPMailer();
        $mailer->SMTPKeepAlive = true;
        $mailer->Subject = $subject;

        $mailer->msgHTML(utf8_decode(self::generateEmailTemplate(utf8_encode($content))));

        foreach ($to as $row) {

            try {
                $mailer->addAddress($row);
            } catch (Exception $e) {
                $log[] = array($row, 'La dirección de correo no es válida.');
                continue;
            }

            try {
                $mailer->send();
            } catch (Exception $e) {
                $log[] = array($row, 'No se pudo enviar el correo.');
                //Reset the connection to abort sending this message
                //The loop will continue trying to send to the rest of the list
                $mailer->getSMTPInstance()->reset();
            }

            //Clear all addresses and attachments for the next iteration
            $mailer->clearAddresses();
            $mailer->clearAttachments();
        }

        return $log;
    }

    private function generateEmailTemplate($html)
    {
        $login_path = 'http://152.200.131.82:18080/admisiones/modules/login/';

        return <<<EOT
            <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
            <html xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office" style="font-family:arial, 'helvetica neue', helvetica, sans-serif">
            <head> 
            <meta charset="UTF-8"> 
            <meta content="width=device-width, initial-scale=1" name="viewport"> 
            <meta name="x-apple-disable-message-reformatting"> 
            <meta http-equiv="X-UA-Compatible" content="IE=edge"> 
            <meta content="telephone=no" name="format-detection"> 
            <style type="text/css">
            #outlook a {
                padding:0;
            }
            .es-button {
                mso-style-priority: 100 !important;
                text-decoration:none!important;
            }
            a[x-apple-data-detectors] {
                color:inherit!important;
                text-decoration:none!important;
                font-size:inherit!important;
                font-family:inherit!important;
                font-weight:inherit!important;
                line-height:inherit!important;
            }
            .es-desk-hidden {
                display:none;
                float:left;
                overflow:hidden;
                width:0;
                max-height:0;
                line-height:0;
                mso-hide:all;
            }
            [data-ogsb] .es-button {
                border-width:0!important;
                padding:10px 20px 10px 20px!important;
            }
            
            [data-ogsb] .es-button.es-button-1 {
                padding:10px 20px 10px 15px!important;
            }

            @media only screen and (max-width:600px) {p, ul li, ol li, a { line-height:150%!important } h1, h2, h3, h1 a, h2 a, h3 a { line-height:120% } h1 { font-size:30px!important; text-align:left } h2 { font-size:24px!important; text-align:left } h3 { font-size:20px!important; text-align:left } .es-header-body h1 a, .es-content-body h1 a, .es-footer-body h1 a { font-size:30px!important; text-align:left } .es-header-body h2 a, .es-content-body h2 a, .es-footer-body h2 a { font-size:24px!important; text-align:left } .es-header-body h3 a, .es-content-body h3 a, .es-footer-body h3 a { font-size:20px!important; text-align:left } .es-menu td a { font-size:14px!important } .es-header-body p, .es-header-body ul li, .es-header-body ol li, .es-header-body a { font-size:14px!important } .es-content-body p, .es-content-body ul li, .es-content-body ol li, .es-content-body a { font-size:14px!important } .es-footer-body p, .es-footer-body ul li, .es-footer-body ol li, .es-footer-body a { font-size:14px!important } .es-infoblock p, .es-infoblock ul li, .es-infoblock ol li, .es-infoblock a { font-size:12px!important } *[class="gmail-fix"] { display:none!important } .es-m-txt-c, .es-m-txt-c h1, .es-m-txt-c h2, .es-m-txt-c h3 { text-align:center!important } .es-m-txt-r, .es-m-txt-r h1, .es-m-txt-r h2, .es-m-txt-r h3 { text-align:right!important } .es-m-txt-l, .es-m-txt-l h1, .es-m-txt-l h2, .es-m-txt-l h3 { text-align:left!important } .es-m-txt-r img, .es-m-txt-c img, .es-m-txt-l img { display:inline!important } .es-button-border { display:inline-block!important } a.es-button, button.es-button { font-size:18px!important; display:inline-block!important } .es-adaptive table, .es-left, .es-right { width:100%!important } .es-content table, .es-header table, .es-footer table, .es-content, .es-footer, .es-header { width:100%!important; max-width:600px!important } .es-adapt-td { display:block!important; width:100%!important } .adapt-img { width:100%!important; height:auto!important } .es-m-p0 { padding:0px!important } .es-m-p0r { padding-right:0px!important } .es-m-p0l { padding-left:0px!important } .es-m-p0t { padding-top:0px!important } .es-m-p0b { padding-bottom:0!important } .es-m-p20b { padding-bottom:20px!important } .es-mobile-hidden, .es-hidden { display:none!important } tr.es-desk-hidden, td.es-desk-hidden, table.es-desk-hidden { width:auto!important; overflow:visible!important; float:none!important; max-height:inherit!important; line-height:inherit!important } tr.es-desk-hidden { display:table-row!important } table.es-desk-hidden { display:table!important } td.es-desk-menu-hidden { display:table-cell!important } .es-menu td { width:1%!important } table.es-table-not-adapt, .esd-block-html table { width:auto!important } table.es-social { display:inline-block!important } table.es-social td { display:inline-block!important } }

            @media only screen and (max-width: 600px){
                .es-m-p20b{
                    padding-bottom: 0px !important; 
                }
            }

            .styles-btn-j:hover{
                background: #565656!important;
                border-color: #565656!important;
            }

            </style> 
            <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">
            </head> 
            <body style="width:100%;font-family:arial, 'helvetica neue', helvetica, sans-serif;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;padding:0;Margin:0"> 
                <div class="es-wrapper-color" style="background-color:#F6F6F6"> 
                <!--[if gte mso 9]>
                            <v:background xmlns:v="urn:schemas-microsoft-com:vml" fill="t">
                                <v:fill type="tile" color="#f6f6f6"></v:fill>
                            </v:background>
                        <![endif]--> 
                <table class="es-wrapper" width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;padding:0;Margin:0;width:100%;height:100%;background-repeat:repeat;background-position:center top"> 
                    <tr> 
                    <td valign="top" style="padding:0;Margin:0"> 
                    <table class="es-content" cellspacing="0" cellpadding="0" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%"> 
                        <tr> 
                        <td align="center" style="padding:0;Margin:0"> 
                        <table class="es-content-body" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#ffffff;width:600px" cellspacing="0" cellpadding="0" bgcolor="#ffffff" align="center"> 
                            <tr> 
                            <td align="left" style="padding:0;Margin:0"> 
                            <table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px"> 
                                <tr> 
                                <td class="es-m-p0r es-m-p20b" valign="top" align="center" style="padding:0;Margin:0;width:600px"> 
                                <table width="100%" cellspacing="0" cellpadding="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px"> 
                                    <tr> 
                                    <td align="center" style="padding:0;Margin:0;font-size:0px"><img class="adapt-img" src="https://tjyshl.stripocdn.email/content/guids/CABINET_635943da8b286fb3195979fb319265b7/images/foto_estudiantes.jpeg" alt style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic" width="600"></td> 
                                    </tr> 
                                </table></td> 
                                </tr> 
                            </table></td> 
                            </tr> 
                            <tr> 
                            <td align="left" bgcolor="#efefef" style="padding:0;Margin:0;background-color:#efefef"> 
                            <table cellpadding="0" cellspacing="0" width="100%" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px"> 
                                <tr> 
                                <td align="center" valign="top" style="padding:0;Margin:0;width:600px"> 
                                <table cellpadding="0" cellspacing="0" width="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px"> 
                                    <tr> 
                                    <td align="center" style="padding:10px;Margin:0"><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:helvetica, 'helvetica neue', arial, verdana, sans-serif;line-height:21px;color:#198754;font-size:14px"><strong style="font-size:16px">Universidad Internacional del Trópico&nbsp;</strong><span style="font-size:16px"><b>Americano</b></span></p></td> 
                                    </tr> 
                                </table></td> 
                                </tr> 
                            </table></td> 
                            </tr> 
                            <tr> 
                            <td align="left" style="padding:0;Margin:0"> 
                            <table cellpadding="0" cellspacing="0" width="100%" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px"> 
                                <tr> 
                                <td align="center" valign="top" style="padding:0;Margin:0;width:600px"> 
                                <table cellpadding="0" cellspacing="0" width="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px"> 
                                    <tr> 
                                    <td align="left" bgcolor="#ffffff" style="padding:10px;Margin:0">
                                        <p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:helvetica, 'helvetica neue', arial, verdana, sans-serif;line-height:21px;color:#333333;font-size:14px">
                                            $html
                                        </p>
                                        <br><br>
                                        <p style="margin-bottom:0"> Por favor, <b> NO RESPONDA </b> este correo, cualquier inconveniente comunicarse con las lineas de atención al ciudadano o en su defecto acercarse a la institución.</p>
                                        </td> 
                                    </tr> 
                                </table></td> 
                                </tr> 
                            </table></td> 
                            </tr> 
                            <tr> 
                            <td align="left" bgcolor="#fafafa" style="padding:0;Margin:0;background-color:#fafafa"> 
                            <table cellpadding="0" cellspacing="0" width="100%" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px"> 
                                <tr> 
                                <td align="center" valign="top" style="padding:0;Margin:0;width:600px"> 
                                <table cellpadding="0" cellspacing="0" width="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px"> 
                                    <tr> 
                                        <td align="center" bgcolor="#ffffff" style="padding:0;Margin:0;padding-top:10px;padding-bottom:10px">
                                            <span class="es-button-border" style="border-style:solid;border-color:#2CB543;background:#333333;border-width:0px 0px 2px 0px;display:inline-block;border-radius:15px;width:auto;border-bottom-width:0px">
                                                <a href="$login_path" class="styles-btn-j es-button es-button-1" target="_blank" style="mso-style-priority:100 !important;text-decoration:none;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;color:#FFFFFF;font-size:14px;border-style:solid;border-color:#333333;border-width:10px 20px 10px 15px;display:inline-block;background:#333333;border-radius:15px;font-family:helvetica, 'helvetica neue', arial, verdana, sans-serif;font-weight:normal;font-style:normal;line-height:17px;width:auto;text-align:center">
                                                    Ingresar a la plataforma
                                                </a>
                                            </span>
                                        </td> 
                                    </tr> 
                                </table></td> 
                                </tr> 
                            </table></td> 
                            </tr> 
                            <tr> 
                            <td align="left" style="padding:0;Margin:0"> 
                            <table cellpadding="0" cellspacing="0" width="100%" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px"> 
                                <tr> 
                                <td align="center" valign="top" style="padding:0;Margin:0;width:600px"> 
                                <table cellpadding="0" cellspacing="0" width="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px"> 
                                    <tr> 
                                    <td align="center" bgcolor="#008733" style="padding:0;Margin:0;padding-top:10px;padding-bottom:10px"><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:helvetica, 'helvetica neue', arial, verdana, sans-serif;line-height:17px;color:#ffffff;font-size:14px"><strong>Universidad Internacional del Trópico Americano - Admisiones</strong></p></td> 
                                    </tr> 
                                </table></td> 
                                </tr> 
                            </table></td> 
                            </tr> 
                        </table></td> 
                        </tr> 
                    </table></td> 
                    </tr> 
                </table> 
                </div>  
                </body>
            </html>
        EOT;
    }
}
