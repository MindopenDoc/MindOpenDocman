<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->

    <link href="{$g_base_url}/templates/tweeter/css/bootstrap.css" rel="stylesheet">
    <link href="{$g_base_url}/templates/tweeter/css/tweeter.css" rel="stylesheet">
    <style type="text/css">
        {literal}
            body {
                padding-top: 60px;
                padding-bottom: 40px;
                margin-left: 10px;
            }



        {/literal}
    </style>
    <link href="{$g_base_url}/templates/tweeter/css/bootstrap-responsive.css" rel="stylesheet">

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
<script src="{$g_base_url}/templates/tweeter/js/html5.js"></script>
<![endif]-->

    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="{$g_base_url|escape:'html'}/templates/tweeter/images/faviconMR.png">

    <link rel="apple-touch-icon"
        href="{$g_base_url|escape:'html'}/templates/tweeter/images/apple-touch-icon.png">
    <link rel="apple-touch-icon" sizes="72x72"
        href="{$g_base_url|escape:'html'}/templates/tweeter/images/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="114x114"
        href="{$g_base_url|escape:'html'}/templates/tweeter/images/apple-touch-icon-114x114.png">


    {* Must Include This Section *}
    {include file='../../templates/common/head_include.tpl'}

    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <title>{$g_title|escape:'html'}</title>
</head>

<body bgcolor="#eaeff1">

    <div class="form-wrapper">

        <div class="form-box">
            <img src="images/001logo.png" alt="Site Logo" border=0>
            <table border="0" cellspacing="5" cellpadding="5">
                <form action="index.php" method="post">
                    {if $redirection}
                        <input type="hidden" name="redirection" value="{$redirection|escape:'html'}">
                    {/if}
                    <tr>
                        <td>{$g_lang_username}</td>

                    </tr>
                    <tr>
                        <td><input type="Text" name="frmuser"></td>
                    </tr>
                    <tr>
                        <td>{$g_lang_password}</td>

                    </tr>
                    <tr>
                        <td><input type="password" name="frmpass"></td>
                    </tr>
                    <tr>
                        <td colspan="2" align="center"><input type="submit" name="login" class="login-btn"
                                value="{$g_lang_enter}" style="font-size:1rem;"></td>
                    </tr>
                    <tr>
                        <td colspan="2" align="right">
                            {if $g_allow_password_reset eq 'True'}
                                <a
                                    href="{$g_base_url|escape:'html'}/forgot_password.php">{$g_lang_forgotpassword}</a>
                            {/if}
                        </td>
                    </tr>
                    {if $g_demo eq 'True'}
                        Regular User: <br />Username:demo Password:demo<br />
                        Admin User: <br />Username:admin Password:admin<br />
                    {/if}
                    {if $g_allow_signup eq 'True'}
                        <tr>
                            <td colspan="2"><a href="{$g_base_url|escape:'html'}/signup.php">{$g_lang_signup}</a>
                        </tr>
                    {/if}
                </form>
            </table>
        </div>
</div>
<script type="text/javascript" src="http://localhost/opendoc/templates/tweeter/js/bootstrap.min.js"></script>
<input type="hidden" id="csrfp_hidden_data_token" value="csrfp_token">
<input type="hidden" id="csrfp_hidden_data_urls" value='[]'><script type="text/javascript" src="http://localhost/opendoc/vendor/owasp/csrf-protector-php/js/csrfprotector.js"></script>