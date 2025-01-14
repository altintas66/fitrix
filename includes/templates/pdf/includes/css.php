<style>
        * {
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        body {
            margin: 0;
            padding: 20px;
        }
        .invoice-container {
            max-width: 800px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
        } 
        .invoice-header {
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        .company-details {
            text-align: right;
        }
        .company-details div {
            font-size: 13px;
            line-height: 23px;
        }
        .invoice-top-details {
            margin-top: 20px;
            font-size: 13px;
            line-height: 23px;
            text-align: right;
        }
        .company-details h2 {
            margin: 0 0 10px 0;
            font-size: 13px;
            line-height: 23px;
            color: #333;
            line-height: 20px;
        }
        .invoice-title {
            font-size: 29px;
            line-height: 39px;
            font-weight: 500;
            color: #333;
            margin: 0;
        }
        .invoice-info {
            margin-top: 10px;
        }
        .invoice-info div {
            font-size: 14px;
            line-height: 24px;
            color: #333;
        }
        .billing-details, .items {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }
        .billing-details th, .billing-details td {
            padding: 10px 10px 10px 0;
            text-align: left;
        }
        .items th, .items td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }
        .billing-details td {
            font-size: 14px;
            line-height: 24px;
            font-weight: normal;
            color: #333;
        }
        .items th {
            font-size: 14px;
            line-height: 24px;
            font-weight: bold;
            border-width: 0 0 thin 0;
            border-color: #333
        }
        .items td,
        .totals tr td {
            font-size: 14px;
            line-height: 24px;
            color: #333;
            border-width: 0;
        }
        .items tbody tr:nth-child(even) {
            background: #f6f8f9; 
        }
        .items .total-row {
            font-weight: bold;
            background: #fff!important;
        }
        .items .first-row td{
            padding-top: 30px;
        }
        .footer {
            margin-top: 40px;
            font-size: 14px;
            color: #333;
        }
        .footer-zusatz-text {
            margin-top: 30px;
        }
        .logo {
            width: 160px;
            margin-bottom: 30px;
        }
        .items tbody tr td ul li {
            font-size: 14px;
            line-height: 20px;
        }
        .invoice-info-agentur {
            margin-bottom: 20px;
        }
        .invoice-info-agentur u {
            font-size: 12px!important;
        }
        .text-right {
            text-align: right !important;
        }
        .width-100 {
            width: 100%;
        }
        .totals {
            margin-top: 20px;
        }
    </style>