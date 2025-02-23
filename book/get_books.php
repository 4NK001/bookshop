<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View PDF</title>
    <link rel="stylesheet" href="mainstyle/css/style.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.min.js"></script>
    <style>
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
            overflow-y: scroll; /* Enable vertical scrolling */
            position: relative;
        }
        #pdf-canvas {
            border: 1px solid #ddd;
            background-color: #fff;
            display: block;
        }
        .loading {
            font-size: 18px;
            color: #333;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
        .scroll-indicator {
            position: fixed;
            bottom: 10px;
            left: 50%;
            transform: translateX(-50%);
            background: rgba(0, 0, 0, 0.5);
            color: #fff;
            padding: 5px 10px;
            border-radius: 3px;
        }
    </style>
</head>
<body>
    <div class="pdf-container" id="pdf-container">
        <canvas id="pdf-canvas"></canvas>
        <div id="loading-message" class="loading">Loading PDF...</div>
        <div id="scroll-indicator" class="scroll-indicator">Scroll to navigate</div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const urlParams = new URLSearchParams(window.location.search);
            const pdfUrl = urlParams.get('pdf');

            if (!pdfUrl) {
                document.body.innerHTML = '<p>PDF URL is missing.</p>';
                return;
            }

            let pdfDoc = null;
            let pageNum = 1;
            const scale = 1.5;
            const pdfCanvas = document.getElementById('pdf-canvas');
            const ctx = pdfCanvas.getContext('2d');
            const loadingMessage = document.getElementById('loading-message');
            const pdfContainer = document.getElementById('pdf-container');

            function loadPdf(pdfUrl) {
                console.log('Attempting to load PDF from:', pdfUrl);
                pdfjsLib.getDocument(pdfUrl).promise.then(pdf => {
                    pdfDoc = pdf;
                    renderPage(pageNum);
                }).catch(error => {
                    console.error('PDF.js error:', error);
                    document.body.innerHTML = `<p>Error loading PDF: ${error.message}. URL attempted: ${pdfUrl}</p>`;
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
                        loadingMessage.style.display = 'none';
                        pdfContainer.style.height = `${viewport.height}px`;
                        pdfContainer.scrollTop = (num - 1) * viewport.height;
                    }).catch(error => {
                        console.error('Render error:', error);
                        document.body.innerHTML = `<p>Error rendering page: ${error.message}</p>`;
                    });
                }).catch(error => {
                    console.error('Page fetch error:', error);
                    document.body.innerHTML = `<p>Error fetching page: ${error.message}</p>`;
                });
            }

            pdfContainer.addEventListener('scroll', () => {
                if (pdfDoc) {
                    const scrollTop = pdfContainer.scrollTop;
                    const viewportHeight = pdfCanvas.height;
                    pageNum = Math.floor(scrollTop / viewportHeight) + 1;
                    if (pageNum < 1) pageNum = 1;
                    if (pageNum > pdfDoc.numPages) pageNum = pdfDoc.numPages;
                    renderPage(pageNum);
                }
            });

            loadPdf('/uploads/' + pdfUrl); // Ensure the path is correct
        });
    </script>
</body>
</html>
