<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Courier Receipt</title>
    <style>
        .container {
            max-width: 400px;
            margin: 20px auto;
        }

        table {
            border-collapse: collapse;
            margin: 0 auto 10px auto;
            width: 100%;
            font-family: Space Grotesk;
        }

        td {
            padding-left: 4px;
            padding-top: 2px;
            padding-bottom: 2px;
            border: 3px solid black;
        }

        .sgn,
        table {
            font-weight: bold;
        }

        .sgn {
            font-family: calibri;
        }

        .kcs {
            font-weight: 900;
            font-size: 27px;
            padding-top: 1px;
            padding-bottom: 1px;
        }

        .add,
        .sgn,
        .kcs,
        .cash,
        .date,
        .weight,
        .mono,
        h1,
        .back-a,
        #generate-pdf {
            text-align: center;
        }

        .date,
        .weight {
            vertical-align: top;
            padding-left: 0;
            padding-right: 0;
        }

        .terms {
            font-size: 12px;
            font-family: calibri;
            padding-left: 2px;
            padding-top: 0px;
            padding-bottom: 0px;
        }

        .back-a,
        #generate-pdf {
            font-size: 25px;
            font-weight: bolder;
            border: solid 2px black;
            text-decoration: none;
            transition: all 0.9s ease;
            display: block;
            margin: 0 auto;

        }

        #generate-pdf {
            color: darkgoldenrod;
            margin-bottom: 0;
        }

        .back-a {
            color: black;
            margin-top: 0;
            width: fit-content;
            color: black;
            margin-top: 10px;
        }

        .back-a:hover,
        #generate-pdf:hover {
            text-decoration: underline;
            color: orangered;
            font-size: 34px;
            cursor: pointer;
        }

        span {
            color: red;
            font-weight: 100px;
        }
    </style>
    <script src="jspdf.umd.min.js"></script>
    <script src="html2canvas.min.js"></script>
    <script src="qrious.min.js"></script>

</head>

<body>
    <div class="container">
        <table id="receipt">
            <tr class="sgn">
                <td colspan="2">|| SHREE GANESHAY NAMAH ||</td>
            </tr>

            <tr>
                <td colspan="2" class="kcs"><b>KULDEVI COURIER SERVICE</b></td>
            </tr>

            <tr class="add">
                <td colspan="2">Shop no G-70 Atlanta Shopping Mall, Althan, Surat-395017</td>
            </tr>

            <tr>
                <td class="mono">Mo.no:- 9328244861, 9427549561, 7016142681</td>
                <td class="cash">CASH</td>
            </tr>

            <tr>
                <td>Fulfilled By:-
                    <span><?php echo $_GET['courier']; ?></span>
                </td>
                <td class="date" rowspan="2">
                    Date<br>
                    <span><?php echo $_GET['date']; ?></span>
                </td>
            </tr>

            <tr>
                <td>Tracking ID:-
                    <span><?php echo $_GET['cn_no']; ?></span>
                </td>
            </tr>

            <tr>
                <td>Station:-
                    <span><?php echo $_GET['city']; ?></span>
                </td>
                <td class="weight" rowspan="2">Weight <br>
                    <span class="wgt"><?php echo $_GET['weight']; ?> Kg</span>
                </td>
            </tr>

            <tr>
                <td>Pin code:-
                    <span><?php echo $_GET['pincode']; ?></span>
                </td>
            </tr>

            <tr>
                <td colspan="2">Sender's Name:-
                    <span><?php echo $_GET['sndr']; ?></span>
                </td>
            </tr>

            <tr>
                <td colspan="2">Receiver's Name:-
                    <span><?php echo $_GET['rcvr']; ?></span>
                </td>
            </tr>

            <tr>
                <td colspan="2">Amount:-
                    <span><?php echo $_GET['shpr_amt']; ?>/-</span>
                </td>
            </tr>

            <tr>
                <td colspan="2" class="terms">
                    TERMS (1)This memo is only for document/packed of papers/parcels of Goods. (2)In case of lost theft, damage, mishandling and/or misused of booked consignment of maximum liability of the company shall not be exceeds to the sum equivalent to three times of Couriers Charges. (3)The Currency, bean cheques, hundis, rukka, bearer bilty, stock & investment certificates, lottery tickets, postal articles and/or similar other documents, Gold Silver Jewellery, Precious Stones Liquid semi-Liquid restricted by Statutory Law. (4)Sender's must indicate the actual and correct nature of goods. (5)No complaint/claim shall be entertained by the company after the expiry of 30 days of the booking of consignment. (6)All disputes are subject to Surat Jurisdiction. (7)In case of valuable parcel consignor should declare the value and any pay the guarantee charges 2% and separate receipt of the charges be issued by otherwise claim will not be considered.
                </td>
            </tr>
        </table>
        <button id="generate-pdf">Generate PDF</button>
        <a class="back-a" href="genreciept.php">Back</a>
    </div>
</body>
<script>document.addEventListener('DOMContentLoaded', () => {
    const {
        jsPDF
    } = window.jspdf;

    document.getElementById('generate-pdf').addEventListener('click', () => {
        const element = document.getElementById('receipt');
        if (element) {
            html2canvas(element, {
                scrollX: 0,
                scrollY: -window.scrollY,
                useCORS: true,
                scale: 2 // Increase scale for better quality
            }).then(canvas => {
                const imgData = canvas.toDataURL('image/png');
                const pdf = new jsPDF({
                    orientation: 'p',
                    unit: 'mm',
                    format: 'a4'
                });

                const pdfWidth = pdf.internal.pageSize.getWidth();
                const pdfHeight = pdf.internal.pageSize.getHeight();
                const margin = 20;
                const imgWidth = pdfWidth - 2 * margin;
                const imgHeight = canvas.height * imgWidth / canvas.width;
                let heightLeft = imgHeight;

                const positionX = margin;
                const positionY = margin - 15;

                pdf.addImage(imgData, 'PNG', positionX, positionY, imgWidth, imgHeight);
                heightLeft -= pdfHeight;

                while (heightLeft >= 0) {
                    pdf.addPage();
                    pdf.addImage(imgData, 'PNG', positionX, positionY, imgWidth, imgHeight);
                    heightLeft -= pdfHeight;
                }

                //urlparams
                const urlParams = new URLSearchParams(window.location.search);
                const cn_no = urlParams.get('cn_no') || 'receipt';
                const trackurl = urlParams.get('trackurl') || '#';

                //click here image
                const imgURL = 'clickhere.png'; //  image URL
                const imgSize = 40;
                const imgpositionX = (pdfWidth - imgSize) / 2 - 50; // Center the image horizontally
                const imgpositionY = pdfHeight - 59.5; // Align vertically 
                pdf.addImage(imgURL, 'PNG', imgpositionX, imgpositionY, imgSize, imgSize);

                // Add a clickable link over the image
                pdf.link(imgpositionX, imgpositionY, imgSize, imgSize, {
                    url: trackurl
                });

                // To track text
                const track = 'To Track Your Parcel';
                const trackTextX = pdfWidth - 195; // Position
                const trackTextY = pdfHeight - 14.5; // Align it vertically 

                pdf.setFontSize(25);
                pdf.setTextColor(25, 25, 112);
                pdf.text(track, trackTextX, trackTextY);

                // Underline for "To Track Your Parcel"
                const trackTextWidth = pdf.getTextWidth(track);
                const trackUnderlineStartX = trackTextX;
                const trackUnderlineEndX = trackTextX + trackTextWidth+5;
                const trackUnderlineY = trackTextY + 1.5; // Slightly below the text

                pdf.setDrawColor(25, 25, 112); // Set line color to match text color
                pdf.setLineWidth(0.8); // Set line width for underline
                pdf.line(trackUnderlineStartX, trackUnderlineY, trackUnderlineEndX, trackUnderlineY);

                // Draw a vertical line
                const lineX = (pdfWidth / 2) - 1; // Center the line
                const lineYStart = pdfHeight - 58;
                const lineYEnd = pdfHeight -3;

                pdf.setDrawColor(0, 0, 0); // Set line color to black
                pdf.setLineWidth(1.5); // Set line width
                pdf.line(lineX, lineYStart, lineX, lineYEnd); // Draw vertical line

                // QR Code Generation
                const qr = new QRious({
                    value: trackurl, // Use the tracking URL to generate the QR code
                    size: 150 // Size of the QR code
                });

                const qrDataUrl = qr.toDataURL();
                const qrSize = 35; // Adjust size as needed

                pdf.addImage(qrDataUrl, 'PNG', ((pdfWidth - qrSize) / 2) + 50, pdfHeight - 56, qrSize, qrSize);

                // Scan text
                const scanText = 'Scan QR Code To Track';
                const scanTextX = pdfWidth - 100; // Position
                const scanTextY = pdfHeight - 14.5; // Align it vertically 

                pdf.setFontSize(25);
                pdf.setTextColor(25, 25, 112);
                pdf.text(scanText, scanTextX, scanTextY);

                // Underline for "Scan QR Code To Track"
                const scanTextWidth = pdf.getTextWidth(scanText);
                const scanUnderlineStartX = scanTextX;
                const scanUnderlineEndX = scanTextX + scanTextWidth+3;
                const scanUnderlineY = scanTextY + 1.5; // Slightly below the text

                pdf.setDrawColor(25, 25, 112); // Set line color to match text color
                pdf.setLineWidth(0.8); // Set line width for underline
                pdf.line(scanUnderlineStartX, scanUnderlineY, scanUnderlineEndX, scanUnderlineY);

                const filename = 'receipt_' + cn_no + '.pdf';
                pdf.save(filename);
            }).catch(error => {
                console.error('Error generating PDF with html2canvas:', error);
                alert('Error generating PDF with html2canvas:', error);
            });
        } else {
            console.error('Element with ID "receipt" not found.');
            alert('Element with ID "receipt" not found.');
        }
    });
});
</script>



</html>