<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <title>DSWD CAR : Certificate of Completion</title>

    {{--<link href="https://fonts.googleapis.com/css?family=Dancing+Script:400,700" rel="stylesheet">--}}
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Lobster+Two:400,700" rel="stylesheet">



    <style>
        /* @font-face {
            font-family: 'Lobster Two';
            src: url({{public_path('/fonts/lobster/LobsterTwo-Bold.ttf')}}) format('truetype'),
            url({{public_path('/fonts/lobster/LobsterTwo-BoldItalic.ttf')}}) format('truetype'),
            url({{public_path('/fonts/lobster/LobsterTwo-Italic.ttf')}}) format('truetype'),
            url({{public_path('/fonts/lobster/LobsterTwo-Regular.ttf')}}) format('truetype'),

        } */
        @font-face {
            font-family: 'Old English Text MT';
            src: url({{public_path('/fonts/old-english-text-mt/OldEnglishTextMT2.ttf')}}) format('truetype')
        }

        @font-face {
            font-family: 'Arial';
            src: url({{public_path('/fonts/Arial.ttf')}}) format('truetype')
        }
        @page {  margin:0px; }

        body, h1, h2, h3, h4, span, div {
            /*font-family: 'Dancing Script', cursive;*/
            font-family: 'Old English Text MT', 'Arial';
        }

        b{
            font-family: 'Arial' !important;
        }

        body {
            margin: 0px;
            /* color: #37231a; */

        }

        .main-border {
            border: 20px solid darkred;
        }

        .row {
            position: relative;
        }

        /*.main-border .row{*/
        /*height: 800px;*/
        /*}*/
        .main-border .row h1 {
            font-size: 80px;
        }

        .banner {
            position: absolute;
            left: 0;
            right: 0;
            margin: auto;
        }

        .badge-img {
            right: 0;
            top: 0;
        }

        .logo {
            left: 40%;
            position: absolute;
            bottom: 22%;
            right: 0; 
            display: inline-block;
            margin: auto;
        }

        /*.container-fluid {*/
        /*width: 1200px;*/
        /*height: 855px;*/
        /*}*/

        .wrapper {
            position: absolute;
            left: 0;
            top: 50%;
            right: 0;
            margin: auto;
        }

        .text-block {
            position: absolute;
            right: 0;
            margin: auto;
            top: 30%;
            left: 0;
            text-align: center;
        }

        .text-block p {
            line-height: 1;
            margin-top: 5px;
            font-size: 50px;
        }
        .text-block span {
            font-size: 12pt;
            font-family: Arial !important;
        }

        .address {
            position: absolute;
            right: 0;
            left: 0;
            top: 18%;
            margin: auto;
            text-align: center;
        }

        .address p {
            line-height: 0.5;
            font-family: "Times New Roman";
            font-size: 10pt;
        }

        .font-weight-bold {
            font-weight: bolder;
        }

        .cert-header-container{
            /* background: url('../../../public/images/certificate_design.png') no-repeat;
            background-size: cover; */
            position: relative;
        }

        .certificate-design{
            position: absolute;
            top: 0;
            left: -5px;
            margin-top: -110px;            
            transform: scale(1.05, 1.05), rotate(05deg);
        }

        .cert-header-container{
            position: relative;
            width: 100%;
        }

        .cert-header-container .dswd-logo-container{
            position: absolute;
            width: 200px;
            left: 0;
            margin: 25px 0 0 50px;
        }

        .cert-header-container .dswd-autonomous-container{
            position: absolute;
            width: 70px;
            right: 0;
            margin: 25px 50px 0 0;
            
        }

        .cert-footer-container{
            font-family: 'Arial';
            position: absolute;
            bottom: 0;
            margin-bottom: 25px;
            width: 100%;
        }

        .cert-footer-container .council-container,
        .cert-footer-container .signatory-container{
            position: relative;
            display: inline-block;
        }

        .cert-footer-container .council-container{
            left: 0;
            margin: 0px 10px 25px 50px;
            width: 250px;            
            text-align: left;
        }

        .cert-footer-container .council-container p,
        .cert-footer-container .council-container p b{
            font-family: 'Arial' !important;
            font-size: 11px;
        }

        .cert-footer-container .council-container p{
            display: inline-block;            
            text-align: left !important;
        }

        .cert-footer-container .signatory-container ul{
            padding: 0;
            list-style-type: none;
        }

        .cert-footer-container .signatory-container ul li{            
            /* width: 100px; */            
            display: inline-block;            
        }        

        .one-sig{
            margin-left: 135px;
        }

        .two-sig{
            margin-left: 40px;
        }

        .cert-footer-container .signatory-container ul li p{
            font-family: 'Arial';
            text-align: center;
            display: inline-block;
            margin-top: 15px;
        }

    </style>
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>

    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container-fluid px-0" style="height: 100%">
    <div class="cert-header-container">
        <img class="certificate-design" width="100%" src="{{public_path('images/certificate_design.png')}}">
        <div class="dswd-logo-container">
            <img width="100%" src="{{public_path('images/dswd_car_logo.png')}}">
        </div>
        <div class="dswd-autonomous-container">
        <img width="100%" src="{{public_path('images/autonomous_logo.png')}}">
        </div>
    </div>
    <div style="position: relative;text-align: center"
         class="row h-100 justify-content-center text-center position-relative m-0">
        <!-- <img class="logo" src="{{public_path('storage/logos/'.config('logo_b_image'))}}"> -->

        <div class = "col-12 address align-self-center">
            <p>Republic of the Philippines</p>
            <p>Department of Social Welfare and Development</p>
            <p>Cordillera Administrative Region</p>
            <p>Baguio City</p>
        </div>

        <div class="col-12 text-block align-self-center">

            <p style="word-wrap: break-word;white-space: nowrap;font-size: 45pt; color: #002060;font-weight-bold;">
                Certificate of Completion
            </p>

            <p style="word-wrap: break-word;white-space: nowrap">
                <span>  is presented to </span>
            </p>

            <p style="word-wrap: break-word;white-space: nowrap">
                <span class="font-weight-bold" style="font-size: 27pt;">
                    {{$data['name']}}
                </span>
            </p>

            <p style="word-wrap: break-word;white-space: nowrap">
                <span> for having successfully completed the </span>
            </p>

            <p style="word-wrap: break-word;white-space: nowrap">
                <span class="font-weight-bold" style="font-size: 21pt; color: #002060;"> " {{$data['course_name']}} " </span>
            </p>

            <p style="word-wrap: break-word;white-space: nowrap">
                <span>
                    Held on {{$data['date']}} <br>
                    at {{config('app.name')}} online course
                </span>
            </p>

            <p style="word-wrap: break-word;white-space: nowrap">
                <span>
                    Given this {{date('l, jS \d\a\y \of F')}} in the year of our Lord <br>
                    {{date('Y')}}
                </span>
            </p>
        </div>

        <!-- <img width="100%" src="{{public_path('images/cert_template_1.jpg')}}"> -->
        <div class="cert-footer-container">
            <div class="council-container">
                <p>
                    <b>PRC-CPD Council for Social Work</b> </br>
                    Accreditation No: 2020 – 00X – 00X </br>
                    Credit Unit: 00.00 </br>
                </p>
            </div>
            <div class="signatory-container">
                <ul>
                    <li class="one-sig">
                        <p>
                            <b>ARNEL B. GARCIA, CESO II</b> </br>
                            Regional Director
                        </p>
                    </li>
                    <!-- <li class="two-sig">
                        <p>
                            <span class="bold">LEO L. QUINTILLA</span> </br>
                            OIC – Regional Director
                        </p>
                    </li> -->
                </ul>
                
            </div>        

        </div>
    </div>
    
</div>
</body>
</html>