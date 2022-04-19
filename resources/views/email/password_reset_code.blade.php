<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>{{env('APP_NAME')}}</title>
    <style type="text/css" rel="stylesheet" media="all">
        /* Base ------------------------------ */

        *:not(br):not(tr):not(html) {
            font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif;
            box-sizing: border-box;
        }

        body {
            width: 100% !important;
            height: 100%;
            margin: 0;
            line-height: 1.4;
            background-color: #F2F4F6;
            color: #74787E;
            -webkit-text-size-adjust: none;
        }

        p,
        ul,
        ol,
        blockquote {
            line-height: 1.4;
            text-align: left;
        }

        a {
            color: #3869D4;
        }

        a img {
            border: none;
        }

        td {
            word-break: break-word;
        }

        /* Layout ------------------------------ */

        .email-wrapper {
            width: 600px;
            margin: 0 auto;
            padding: 0;
            -premailer-width: 100%;
            -premailer-cellpadding: 0;
            -premailer-cellspacing: 0;
            background-color: #F2F4F6;
        }

        .email-content {
            width: 100%;
            margin: 0;
            padding: 0;
            -premailer-width: 100%;
            -premailer-cellpadding: 0;
            -premailer-cellspacing: 0;
        }

        /* Masthead ----------------------- */

        .email-masthead {
            padding: 25px 0;
            text-align: center;
        }

        .email-masthead_logo {
            width: 94px;
        }

        .email-masthead_name {
            font-size: 16px;
            font-weight: bold;
            color: #bbbfc3;
            text-decoration: none;
            text-shadow: 0 1px 0 white;
        }

        /* Body ------------------------------ */

        .email-body {
            width: 100%;
            margin: 0;
            padding: 0;
            -premailer-width: 100%;
            -premailer-cellpadding: 0;
            -premailer-cellspacing: 0;
            border-top: 1px solid #EDEFF2;
            border-bottom: 1px solid #EDEFF2;
            background-color: #FFFFFF;
        }

        .email-body_inner {
            width: 570px;
            margin: 0 auto;
            padding: 0;
            -premailer-width: 570px;
            -premailer-cellpadding: 0;
            -premailer-cellspacing: 0;
            background-color: #FFFFFF;
        }

        .email-footer {
            width: 570px;
            margin: 0 auto;
            padding: 0;
            -premailer-width: 570px;
            -premailer-cellpadding: 0;
            -premailer-cellspacing: 0;
            text-align: center;
        }

        .email-footer p {
            color: #AEAEAE;
        }

        .body-action {
            width: 100%;
            margin: 30px auto;
            padding: 0;
            -premailer-width: 100%;
            -premailer-cellpadding: 0;
            -premailer-cellspacing: 0;
            text-align: center;
        }

        .body-sub {
            margin-top: 25px;
            padding-top: 25px;
            border-top: 1px solid #EDEFF2;
        }

        .content-cell {
            padding: 35px;
        }

        .preheader {
            display: none !important;
            visibility: hidden;
            mso-hide: all;
            font-size: 1px;
            line-height: 1px;
            max-height: 0;
            max-width: 0;
            opacity: 0;
            overflow: hidden;
        }

        /* Attribute list ------------------------------ */

        .attributes {
            margin: 0 0 21px;
        }

        .attributes_content {
            background-color: #EDEFF2;
            padding: 16px;
        }

        .attributes_item {
            padding: 0;
        }

        /* Related Items ------------------------------ */

        .related {
            width: 100%;
            margin: 0;
            padding: 25px 0 0 0;
            -premailer-width: 100%;
            -premailer-cellpadding: 0;
            -premailer-cellspacing: 0;
        }

        .related_item {
            padding: 10px 0;
            color: #74787E;
            font-size: 15px;
            line-height: 18px;
        }

        .related_item-title {
            display: block;
            margin: .5em 0 0;
        }

        .related_item-thumb {
            display: block;
            padding-bottom: 10px;
        }

        .related_heading {
            border-top: 1px solid #EDEFF2;
            text-align: center;
            padding: 25px 0 10px;
        }

        /* Discount Code ------------------------------ */

        .discount {
            width: 100%;
            margin: 0;
            padding: 24px;
            -premailer-width: 100%;
            -premailer-cellpadding: 0;
            -premailer-cellspacing: 0;
            background-color: #EDEFF2;
            border: 2px dashed #9BA2AB;
        }

        .discount_heading {
            text-align: center;
        }

        .discount_body {
            text-align: center;
            font-size: 15px;
        }

        /* Social Icons ------------------------------ */

        .social {
            width: auto;
        }

        .social td {
            padding: 0;
            width: auto;
        }

        .social_icon {
            height: 20px;
            margin: 0 8px 10px 8px;
            padding: 0;
        }

        /* Data table ------------------------------ */

        .purchase {
            width: 100%;
            margin: 0;
            padding: 35px 0;
            -premailer-width: 100%;
            -premailer-cellpadding: 0;
            -premailer-cellspacing: 0;
        }

        .purchase_content {
            width: 100%;
            margin: 0;
            padding: 25px 0 0 0;
            -premailer-width: 100%;
            -premailer-cellpadding: 0;
            -premailer-cellspacing: 0;
        }

        .purchase_item {
            padding: 10px 0;
            color: #74787E;
            font-size: 15px;
            line-height: 18px;
        }

        .purchase_heading {
            padding-bottom: 8px;
            border-bottom: 1px solid #EDEFF2;
        }

        .purchase_heading p {
            margin: 0;
            color: #9BA2AB;
            font-size: 12px;
        }

        .purchase_footer {
            padding-top: 15px;
            border-top: 1px solid #EDEFF2;
        }

        .purchase_total {
            margin: 0;
            text-align: right;
            font-weight: bold;
            color: #2F3133;
        }

        .purchase_total--label {
            padding: 0 15px 0 0;
        }

        /* Utilities ------------------------------ */

        .align-right {
            text-align: right;
        }

        .align-left {
            text-align: left;
        }

        .align-center {
            text-align: center;
        }

        /*Media Queries ------------------------------ */

        @media only screen and (max-width: 600px) {
            .email-body_inner,
            .email-footer {
                width: 100% !important;
            }
        }

        @media only screen and (max-width: 500px) {
            .button {
                width: 100% !important;
            }
        }

        /* Buttons ------------------------------ */

        .button {
            background-color: #1f2d6b !important;
            padding: 10px 20px;
            display: block;
            color: #FFF !important;
            text-align: center;
            width: 500px;
            text-decoration: none;
            border-radius: 3px;
            box-shadow: 0 2px 3px rgba(0, 0, 0, 0.16);
            -webkit-text-size-adjust: none;
        }

        .button--green {
            background-color: #22BC66;
            border-top: 10px solid #22BC66;
            border-right: 18px solid #22BC66;
            border-bottom: 10px solid #22BC66;
            border-left: 18px solid #22BC66;
        }

        .button--red {
            background-color: #1f2d6b;
            border-top: 10px solid #1f2d6b;
            border-right: 18px solid #1f2d6b;
            border-bottom: 10px solid#1f2d6b;
            border-left: 18px solid #1f2d6b;
        }

        /* Type ------------------------------ */

        h1 {
            margin-top: 0;
            color: #2F3133;
            font-size: 19px;
            font-weight: bold;
            text-align: left;
        }

        h2 {
            margin-top: 0;
            color: #2F3133;
            font-size: 16px;
            font-weight: bold;
            text-align: left;
        }

        h3 {
            margin-top: 0;
            color: #2F3133;
            font-size: 14px;
            font-weight: bold;
            text-align: left;
        }

        p {
            margin-top: 0;
            color: #74787E;
            font-size: 16px;
            line-height: 1.5em;
            text-align: left;
        }
        p a{color:#f7941e;}

        p.sub {
            font-size: 12px;
        }

        p.center {
            text-align: center;
        }
    </style>
</head>

<body>
<?php
$base_url = url('/');
?>
<table class="email-wrapper" width="100%" cellpadding="0" cellspacing="0">
    <tr>
        <td align="center">
            <table class="email-content" width="100%" cellpadding="0" cellspacing="0">
                <tr>
                    <td class="email-masthead">
                        <a href="javascript:;" class="email-masthead_name">
                            <img style="width:190px;" src="{{ asset('/frontend/images/logo.png') }}">
                        </a>
                    </td>
                </tr>
                <!-- Email Body -->
                <tr>
                    <td class="email-body" width="100%" cellpadding="0" cellspacing="0">
                        <table class="email-body_inner" align="center" width="570" cellpadding="0" cellspacing="0">
                            <img style="width:100%; height:150px;" src="{{asset('/frontend/images/inner-header.png')}}" alt="" />
                            <!-- Body content -->
                            <tr>
                                <td class="content-cell">
                                    <p>{{ $user->name }}, you requested password reset verification code</p>
                                    <p>
                                        <a href="javascript:;">{{ $code }}</a>
                                    </p>
                                    <p>If you did not request this code, please ignore this email. </p>
                                    <p>If you have any questions, feel free to  <a href="mailto:{{env('APP_EMAIL')}}">email our customer support team</a>. (We're lightning quick at replying.)
                                    <p>Thanks,
                                    <br>{{env('APP_NAME')}} Support Team</p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table class="email-footer" align="center" width="570" cellpadding="0" cellspacing="0">
                            <tr>
                                <td class="content-cell" align="center">
                                    <p class="sub align-center">&copy; {{date('Y')}} {{env('APP_NAME')}}. All rights reserved.</p>
                                    <p class="sub align-center">
                                        {{env('APP_NAME')}}.
                                    </p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>

</html>
