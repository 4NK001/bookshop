<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View PDF</title>
    <link rel="stylesheet" href="mainstyle/css/style.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.min.js"></script>
    <style>
        /* Style the PDF viewer page */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .pdf-container {
            width: 100%;
            height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background-color: #f8f8f8;
        }
        #pdf-canvas {
            border: 1px solid #ddd;
            background-color: #fff;
        }
        .controls {
            margin-top: 10px;
        }
        .pdf-btn {
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            cursor: pointer;
            margin: 5px;
        }
        .pdf-btn:disabled {
            background-color: #ccc;
        }
    </style>
</head>
<body>
    <div class="pdf-container">
        <canvas id="pdf-canvas"></canvas>
        <div class="controls">
            <button id="prev-page" class="pdf-btn">Previous</button>
            <button id="next-page" class="pdf-btn">Next</button>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const urlParams = new URLSearchParams(window.location.search);
            const pdfUrl = urlParams.get('pdf');

            if (!pdfUrl) {
                console.error('PDF URL is missing.');
                return;
            }

            let pdfDoc = null;
            let pageNum = 1;
            const scale = 1.5;
            const pdfCanvas = document.getElementById('pdf-canvas');
            const ctx = pdfCanvas.getContext('2d');

            function loadPdf(pdfUrl) {
                pdfjsLib.getDocument(pdfUrl).promise.then(pdf => {
                    pdfDoc = pdf;
                    renderPage(pageNum);
                }).catch(error => {
                    console.error('Error loading PDF:', error);
                });
            }

            function renderPage(num) {
                pdfDoc.getPage(num).then(page => {
                    const viewport = page.getViewport({ scale });
                    pdfCanvas.height = viewport.height;
                    pdfCanvas.width = viewport.width;

                    const renderContext = {
                        canvasContext: ctx,
                        viewport: viewport
                    };
                    const renderTask = page.render(renderContext);

                    renderTask.promise.then(() => {
                        document.getElementById('prev-page').disabled = num === 1;
                        document.getElementById('next-page').disabled = num >= pdfDoc.numPages;
                    });
                });
            }

            document.getElementById('prev-page').addEventListener('click', () => {
                if (pageNum <= 1) return;
                pageNum--;
                renderPage(pageNum);
            });

            document.getElementById('next-page').addEventListener('click', () => {
                if (pageNum >= pdfDoc.numPages) return;
                pageNum++;
                renderPage(pageNum);
            });

            loadPdf('/uploads/' + pdfUrl); // Ensure the path is correct
        });
    </script>
</body>
</html>
