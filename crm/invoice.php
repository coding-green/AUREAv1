<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tax Invoice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .invoice-box {
            max-width: 800px;
            margin: 40px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }
        .title {
            font-size: 24px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 20px;
            text-transform: uppercase;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table th, table td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }
        table th {
            background-color: #f9f9f9;
            font-weight: bold;
        }
        .company-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .company-info .logo img {
            max-width: 100px;
            height: auto;
        }
        .qr-code img {
            max-width: 100px;
            height: auto;
        }
        .total-section {
            background-color: #f9f9f9;
            font-weight: bold;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 12px;
            color: #777;
        }
        .footer small {
            display: block;
        }
        .amount-in-words {
            margin: 20px 0;
            font-weight: bold;
            text-transform: capitalize;
        }
        .declaration {
            margin-top: 20px;
            font-size: 14px;
            font-style: italic;
        }
    </style>
</head>
<body>

<div class="invoice-box">
    <!-- Company Info & Logo -->
    <div class="company-info">
        <div>
            <strong>Global Medical Devices</strong><br>
            Office No.05, First Floor, Choice Arcade,<br>
            Dhole Patil Road, Pune-411001<br>
            Mob: 9890014348<br>
            Email: globalmedicaldevices@gmail.com<br>
            GSTIN/UIN: 27ACQPT4592G1ZV<br>
        </div>
        <div class="logo">
            <img src="logo-placeholder.png" alt="Company Logo">
        </div>
    </div>

    <div class="title">Tax Invoice</div>

    <!-- Invoice Details -->
    <table class="details" cellpadding="0" cellspacing="0">
        <tr>
            <td><strong>Invoice No.:</strong> GMD212/24-25</td>
            <td><strong>Date:</strong> 02.09.2024</td>
        </tr>
        <tr>
            <td><strong>Challan No.:</strong> 212</td>
            <td><strong>Po No.:</strong> 359/NCI-AIIMS/GSK/24-25</td>
        </tr>
        <tr>
            <td><strong>Party:</strong> Stores Incharge, National Cancer Institute<br>
                AIIMS, Village: Badsha Dist. Jhajjar, Haryana - 124507<br>
                Mobile No.: +91 8527334444
            </td>
            <td><strong>GSTIN/UIN:</strong> Haryana, Code 06</td>
        </tr>
    </table>

    <!-- Product Details -->
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th>SI No.</th>
            <th>Description of Goods</th>
            <th>HSN/SAC</th>
            <th>Quantity</th>
            <th>Rate</th>
            <th>Per</th>
            <th>Amount</th>
        </tr>
        <tr>
            <td>1</td>
            <td>Refilling of Cylinder for DLCO & PFT Machine<br>(Mixture in 10ltr Cylinder-03% CO, 0.3% CH4, 21% O2, Bal N2)</td>
            <td>28042990</td>
            <td>1.00 Qty</td>
            <td>16500.00</td>
            <td>Nos</td>
            <td>16500.00</td>
        </tr>
        <tr>
            <td>2</td>
            <td>Disposable Paper Mouth Pieces Adult (Pack of 100)</td>
            <td>48229010</td>
            <td>500.00 Qty</td>
            <td>7.15</td>
            <td>Nos</td>
            <td>3575.00</td>
        </tr>
        <tr class="total-section">
            <td colspan="6" align="right"><strong>Total</strong></td>
            <td>20075.00</td>
        </tr>
        <tr>
            <td colspan="6" align="right">Output IGST - 18%</td>
            <td>3613.50</td>
            
        </tr>
        <tr>
            <td colspan="6" align="right">Rounding Off</td>
            <td>-0.50</td>
        </tr>
        <tr class="total-section">
            <td colspan="6" align="right"><strong>Grand Total</strong></td>
            <td><strong>₹ 23688.00</strong></td>
        </tr>
    </table>

    <!-- Amount in Words -->
    <div class="amount-in-words">INR Twenty Three Thousand Six Hundred Eighty Eight Only</div>

    <!-- Tax Breakdown -->
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th>HSN/SAC</th>
            <th>Taxable Value</th>
            <th>Integrated Tax</th>
            <th>Central Tax</th>
            <th>State Tax</th>
            <th>Total Tax Amount</th>
        </tr>
        <tr>
            <td>28042990</td>
            <td>20075.00</td>
            <td>18% - 3613.50</td>
            <td>9% - 0.00</td>
            <td>9% - 0.00</td>
            <td>3613.50</td>
        </tr>
    </table>

    <!-- QR Code -->
    <div class="qr-code">
        <img src="qr-placeholder.png" alt="QR Code">
    </div>

    <!-- Declaration & Footer -->
    <div class="declaration">
        We declare that this invoice shows the actual price of the goods described and that all particulars are true and correct.
    </div>

    <div class="footer">
        <p>Company's PAN: ACQPT4592G &nbsp;|&nbsp; Company's DL: MH-PZ1-285085/MH-PZ1-285086</p>
        <p>Bank Name: HDFC Bank &nbsp;|&nbsp; A/c No.: 15782000000876 &nbsp;|&nbsp; Branch & IFS Code: Kharadi, Pune & HDFC0001578</p>
        <p><small>This is a Computer Generated Invoice<br>SUBJECT TO PUNE JURISDICTION</small></p>
    </div>
</div>

</body>
</html>
