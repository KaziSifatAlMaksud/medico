<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Certificate of Consultation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            background-color: #f8f8f8;
        }
        .certificate-container {
            width: 90%;
            padding: 30px;
            text-align: center;
            border: 10px solid #3b3b3b;
            margin: auto;
            background-color: #fff;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);
            box-sizing: border-box;
        }
        .certificate-header img {
            border-radius: 4px;
            width: 150px;
            height: auto;
        }
        h1 {
            margin: 20px 0;
            font-size: 40px;
            color: #333;
        }
        .date {
            margin: 25px 0 50px;
            text-align: right;
            font-size: 18px;
            color: #666;
        }
        .contenContainer {
            margin-bottom: 40px;
            margin-left: 40px;
            text-align: left;
            font-size: 18px;
            color: #444;
        }
        .contenContainer p {
            margin: 15px 0;
        }
        .contenContainer span {
            color: black;
            font-weight: bold;
        }
        .contenContainerFooter {
            display: flex;
            justify-content: space-between;
            margin-top: 60px;
            padding-top: 20px;
        
            border-top: 1px solid #ccc;
        }
        .footerImg img,
        .stmpImg img,
        .sigImg img {
            margin-left: 40px;
            border-radius: 4px;
            padding: 5px;
            height: auto;
        }
        .footerImg img {
            width: 200px;
  float: left;
        }
        .stmpImg img {
            width: 100px;
        }
        .sigImg img {
            width: 100px;
        }
    </style>
</head>
<body>
    <div class="certificate-container">
        <div class="certificate-header">
            <img src="{{ $logo_image }}" alt="Logo">
        </div>
        <h1>Medical Certificate</h1>
        <div class="date">
            <p>Date: {{ $date }}</p>
        </div>
        <div class="contenContainer">
            <p>THIS IS TO CERTIFY that ___<span>{{ $name }}</span>___ of ___<span>{{ $address }}</span>___</p>
            <p>Was examined at the HealCertify on ____<span>{{ $date }}</span>___</p>
            <p>Issues: ___ <span>{{ $issues }}</span>___</p>
            <p>And would need medical attention for ___<span>{{ $medical_attention_days }}</span>___ days barring complication.</p>
        </div>
        <div class="contenContainerFooter">
            <div class="footerImg">
                <img src="{{ $prescription_image }}" alt="Logo">
            </div>
            <div>
                <div class="stmpImg">
                    <img src="{{ $stamp_image }}" alt="Stamp">
                </div>
                <div class="sigImg">
                    <img src="{{ $signature_image }}" alt="Signature">
                </div>
            </div>
        </div>
    </div>
</body>
</html>
