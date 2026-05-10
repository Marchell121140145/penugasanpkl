<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Excel Web Editor - {{ $fileName }}</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Jspreadsheet CE & Jsuites -->
    <script src="https://bossanova.uk/jspreadsheet/v4/jexcel.js"></script>
    <link rel="stylesheet" href="https://bossanova.uk/jspreadsheet/v4/jexcel.css" type="text/css" />
    <script src="https://jsuites.net/v4/jsuites.js"></script>
    <link rel="stylesheet" href="https://jsuites.net/v4/jsuites.css" type="text/css" />
    
    <!-- SheetJS with Style Support (xlsx-js-style) -->
    <script src="https://cdn.jsdelivr.net/npm/xlsx-js-style@1.2.0/dist/xlsx.bundle.js"></script>
    <!-- ExcelJS (For Powerful Binary Write with Complete Style Preservation) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/exceljs/4.3.0/exceljs.min.js"></script>

    <!-- Material Icons untuk Toolbar jSpreadsheet -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f8fafc; }
        .jexcel_container { background: white; margin-top: 10px; width: 100%!important; height: auto!important;}
        .jexcel_content { box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1); border-radius: 8px; overflow: auto !important; max-height: calc(100vh - 120px) !important; max-width: 100% !important; }
        .glass-header {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid #e2e8f0;
        }
    </style>
</head>
<body class="flex flex-col h-screen overflow-hidden">

    <!-- Header Navbar -->
    <header class="glass-header px-6 py-4 flex justify-between items-center z-10 shadow-sm relative">
        <div class="flex items-center gap-4">
            <button onclick="window.history.back()" class="w-10 h-10 flex items-center justify-center rounded-full bg-slate-100 hover:bg-slate-200 text-slate-600 transition-colors" title="Kembali">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5"/><path d="M12 19l-7-7 7-7"/></svg>
            </button>
            <div>
                <h1 class="text-xl font-bold text-slate-800 flex items-center gap-2">
                    <span class="text-emerald-500"><i class="fi fi-rr-chart-histogram"></i></span>
                    <span>{{ $fileName }}</span>
                </h1>
                <p class="text-xs text-slate-500 uppercase font-semibold">Tugas: {{ $task->judul }}</p>
            </div>
        </div>
        
        <div class="flex items-center gap-3">
            <button id="btnSave" onclick="saveExcel()" class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold rounded-lg shadow-md hover:shadow-lg transition-all flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                <span id="saveText">Save & Overwrite</span>
            </button>
        </div>
    </header>

    <!-- Editor Container -->
    <main class="flex-1 w-full flex flex-col bg-slate-50 relative overflow-hidden">
        
        <!-- Loading Overlay -->
        <div id="loadingOverlay" class="absolute inset-0 bg-slate-50 z-50 flex flex-col items-center justify-center">
            <div class="w-12 h-12 border-4 border-emerald-500 border-t-transparent rounded-full animate-spin mb-4"></div>
            <p class="text-slate-600 font-semibold animate-pulse">Memuat file Excel ke dalam Web Engine...</p>
        </div>

        <div id="sheets-container" class="flex-1 w-full relative overflow-auto"></div>
        
        <div id="tab-bar" class="h-10 bg-white border-t border-slate-200 flex items-center px-2 gap-1 overflow-x-auto shadow-inner shrink-0">
             <button id="add-sheet-btn" class="min-w-[32px] h-8 flex items-center justify-center text-slate-500 hover:text-emerald-600 hover:bg-emerald-50 rounded transition-colors" onclick="addNewSheet()" title="Tambah Sheet Baru">
                 <span class="material-icons text-sm" style="font-size: 18px;">add</span>
             </button>
        </div>
    </main>

    <script>
        var spreadsheetInstances = [];
        var activeSheetIndex = 0;

        document.addEventListener('DOMContentLoaded', function() {
            const url = "{{ $fileUrl }}";
            
            fetch(url)
                .then(res => res.arrayBuffer())
                .then(async ab => {
                    const workbook = new ExcelJS.Workbook();
                    await workbook.xlsx.load(ab);
                    
                    document.getElementById('loadingOverlay').style.display = 'none';

                    workbook.eachSheet((worksheet, sheetId) => {
                        createSheetUI(worksheet.name, worksheet);
                    });
                    
                    if (spreadsheetInstances.length > 0) {
                        switchSheet(0);
                    } else {
                        addNewSheet('Sheet1');
                    }
                })
                .catch(err => {
                    console.error(err);
                    document.getElementById('loadingOverlay').innerHTML = `<p class="text-red-500 font-bold">Gagal memuat file Excel.<br>Detail: ${err.message}</p>`;
                });
        });

        function createSheetUI(sheetName, worksheet = null) {
            const index = spreadsheetInstances.length;
            
            // 1. Create Container
            const container = document.createElement('div');
            container.id = 'sheet-container-' + index;
            container.className = 'w-full h-full absolute inset-0 bg-white';
            container.style.display = 'none';
            document.getElementById('sheets-container').appendChild(container);
            
            // 2. Create Tab
            const tabBtn = document.createElement('button');
            tabBtn.id = 'tab-btn-' + index;
            tabBtn.className = 'px-4 h-full text-sm font-medium border-b-2 whitespace-nowrap transition-colors flex items-center gap-2 text-slate-500 border-transparent hover:text-emerald-600 hover:bg-emerald-50';
            tabBtn.innerHTML = `<span>${sheetName}</span> <span class="material-icons text-[14px] cursor-pointer hover:text-red-500 rounded-full hover:bg-red-50" onclick="deleteSheet(event, ${index})" title="Hapus Sheet">close</span>`;
            tabBtn.onclick = () => switchSheet(index);
            
            const tabBar = document.getElementById('tab-bar');
            const addBtn = document.getElementById('add-sheet-btn');
            tabBar.insertBefore(tabBtn, addBtn);
            
            // 3. Prepare Data
            let jsonData = [];
            let jexcelStyles = {};
            
            const getColName = (n) => {
                let str = "";
                while(n >= 0) { str = String.fromCharCode(n % 26 + 65) + str; n = Math.floor(n / 26) - 1; }
                return str;
            };

            if (worksheet) {
                worksheet.eachRow({ includeEmpty: true }, (row, rowNumber) => {
                    const rowData = [];
                    row.eachCell({ includeEmpty: true }, (cell, colNumber) => {
                        rowData[colNumber - 1] = cell.value !== null && cell.value !== undefined ? (cell.value.result ?? cell.value) : '';
                        
                        let css = [];
                        if (cell.font) {
                            if (cell.font.bold) css.push("font-weight: bold");
                            if (cell.font.italic) css.push("font-style: italic");
                            if (cell.font.underline) css.push("text-decoration: underline");
                            if (cell.font.color && cell.font.color.argb) {
                                css.push("color: #" + cell.font.color.argb.substring(2));
                            }
                        }
                        if (cell.fill && cell.fill.fgColor && cell.fill.fgColor.argb) {
                            css.push("background-color: #" + cell.fill.fgColor.argb.substring(2));
                        }
                        
                        if (css.length > 0) {
                            const cellId = getColName(colNumber - 1) + rowNumber;
                            jexcelStyles[cellId] = css.join("; ");
                        }
                    });
                    for(let i=0; i<rowData.length; i++) if(rowData[i]===undefined) rowData[i]='';
                    jsonData[rowNumber - 1] = rowData;
                });
                for(let i=0; i<jsonData.length; i++) if(jsonData[i]===undefined) jsonData[i]=[];
            }

            // 4. Initialize jSpreadsheet
            const instance = jspreadsheet(container, {
                data: jsonData.length > 0 ? jsonData : [[]],
                style: jexcelStyles,
                minDimensions: [20, 50],
                tableOverflow: true,
                tableWidth: '100%',
                tableHeight: 'calc(100vh - 120px)', // adjust based on header + tab bar
                lazyLoading: true,
                defaultColWidth: 150,
                toolbar: [
                    { type: 'i', content: 'format_bold', tooltip: 'Bold', k: 'font-weight', v: 'bold' },
                    { type: 'i', content: 'format_italic', tooltip: 'Italic', k: 'font-style', v: 'italic' },
                    { type: 'i', content: 'format_underline', tooltip: 'Underline', k: 'text-decoration', v: 'underline' },
                    { type: 'color', content: 'format_color_text', tooltip: 'Text Color', k: 'color' },
                    { type: 'color', content: 'format_color_fill', tooltip: 'Background Color', k: 'background-color' },
                ]
            });

            spreadsheetInstances.push({
                name: sheetName,
                instance: instance,
                container: container,
                tabBtn: tabBtn,
                deleted: false
            });
            
            return index;
        }

        function switchSheet(index) {
            if (spreadsheetInstances[index].deleted) return;
            
            activeSheetIndex = index;
            
            spreadsheetInstances.forEach((sheet, i) => {
                if (sheet.deleted) return;
                
                if (i === index) {
                    sheet.container.style.display = 'block';
                    sheet.tabBtn.classList.remove('text-slate-500', 'border-transparent');
                    sheet.tabBtn.classList.add('text-emerald-600', 'border-emerald-600', 'bg-emerald-50');
                } else {
                    sheet.container.style.display = 'none';
                    sheet.tabBtn.classList.add('text-slate-500', 'border-transparent');
                    sheet.tabBtn.classList.remove('text-emerald-600', 'border-emerald-600', 'bg-emerald-50');
                }
            });
        }

        function addNewSheet(defaultName = null) {
            const sheetName = defaultName || prompt("Masukkan nama Sheet baru:", "Sheet" + (spreadsheetInstances.filter(s => !s.deleted).length + 1));
            if (!sheetName) return;
            
            // Check duplicate name
            let exists = spreadsheetInstances.some(s => !s.deleted && s.name === sheetName);
            if (exists) {
                alert("Nama sheet sudah ada!");
                return;
            }
            
            const index = createSheetUI(sheetName);
            switchSheet(index);
        }

        function deleteSheet(event, index) {
            event.stopPropagation();
            const activeSheets = spreadsheetInstances.filter(s => !s.deleted);
            if (activeSheets.length <= 1) {
                alert("Minimal harus ada 1 sheet!");
                return;
            }

            if (confirm(`Yakin ingin menghapus sheet '${spreadsheetInstances[index].name}'?`)) {
                spreadsheetInstances[index].deleted = true;
                spreadsheetInstances[index].container.style.display = 'none';
                spreadsheetInstances[index].tabBtn.style.display = 'none';
                
                // Switch to another active sheet if current was deleted
                if (activeSheetIndex === index) {
                    for (let i = 0; i < spreadsheetInstances.length; i++) {
                        if (!spreadsheetInstances[i].deleted) {
                            switchSheet(i);
                            break;
                        }
                    }
                }
            }
        }

        // Save Function to Send Blob Overwrite request
        function saveExcel() {
            const activeSheets = spreadsheetInstances.filter(s => !s.deleted);
            if (activeSheets.length === 0) return;

            const btnSave = document.getElementById('btnSave');
            const saveText = document.getElementById('saveText');
            saveText.innerText = 'Menyimpan...';
            btnSave.disabled = true;
            btnSave.classList.add('opacity-75', 'cursor-not-allowed');

            try {
                const workbook = new ExcelJS.Workbook();
                
                activeSheets.forEach((sheetInfo) => {
                    const rawData = sheetInfo.instance.getData();
                    
                    let safeName = sheetInfo.name.replace(/[\[\]\*\?\/\\\:]/g, ''); // exceljs illegal chars
                    if (!safeName || safeName.length === 0) safeName = 'Sheet';
                    
                    let finalName = safeName;
                    let count = 1;
                    while(workbook.getWorksheet(finalName)) {
                        finalName = safeName + " " + count;
                        count++;
                    }
                    
                    const worksheet = workbook.addWorksheet(finalName);
                    worksheet.addRows(rawData);
                    
                    const tbody = sheetInfo.container.querySelector('.jexcel tbody');
                    if (tbody) {
                        const rows = tbody.querySelectorAll('tr');
                        rows.forEach((row, rowIndex) => {
                            const cells = row.querySelectorAll('td');
                            cells.forEach((td, colIndex) => {
                                if (colIndex === 0) return; // skip row header
                                const css = td.style.cssText;
                                if (!css) return; 
                                
                                const exCell = worksheet.getCell(rowIndex + 1, colIndex);
                                
                                let fontObj = {};
                                let hasFont = false;

                                if (/font-weight:\s*(bold|700)/i.test(css)) { fontObj.bold = true; hasFont = true; }
                                if (/font-style:\s*italic/i.test(css)) { fontObj.italic = true; hasFont = true; }
                                if (/text-decoration(?:-line)?:\s*underline/i.test(css)) { fontObj.underline = true; hasFont = true; }
                                
                                let colorMatch = css.match(/(?:^|[\s;])color:\s*(rgb\([^)]+\)|#[0-9A-Fa-f]{3,6})/i);
                                if (colorMatch) {
                                    let rgb = colorMatch[1];
                                    let hexColor = "";
                                    if(rgb.startsWith('rgb')) {
                                        let parts = rgb.match(/\d+/g);
                                        if(parts && parts.length >= 3) {
                                            hexColor = ((1 << 24) + (parseInt(parts[0]) << 16) + (parseInt(parts[1]) << 8) + parseInt(parts[2])).toString(16).slice(1).toUpperCase();
                                        }
                                    } else {
                                        hexColor = rgb.replace('#', '').toUpperCase().padEnd(6, '0');
                                    }
                                    if(hexColor) {
                                        fontObj.color = { argb: 'FF' + hexColor };
                                        hasFont = true;
                                    }
                                }
                                if (hasFont) exCell.font = fontObj;
                                
                                let bgMatch = css.match(/(?:^|[\s;])background-color:\s*(rgb\([^)]+\)|#[0-9A-Fa-f]{3,6})/i);
                                if (bgMatch) {
                                    let rgb = bgMatch[1];
                                    let hexColor = "";
                                    if(rgb.startsWith('rgb')) {
                                        let parts = rgb.match(/\d+/g);
                                        if(parts && parts.length >= 3) {
                                            hexColor = ((1 << 24) + (parseInt(parts[0]) << 16) + (parseInt(parts[1]) << 8) + parseInt(parts[2])).toString(16).slice(1).toUpperCase();
                                        }
                                    } else {
                                        hexColor = rgb.replace('#', '').toUpperCase().padEnd(6, '0');
                                    }
                                    if(hexColor) {
                                        exCell.fill = {
                                            type: 'pattern',
                                            pattern: 'solid',
                                            fgColor: { argb: 'FF' + hexColor }
                                        };
                                    }
                                }
                            });
                        });
                    }
                });
                
                // Write to Buffer via ExcelJS
                workbook.xlsx.writeBuffer().then(buffer => {
                    const blob = new Blob([buffer], { type: "application/octet-stream" });
                    
                    // Build Payload
                    const fd = new FormData();
                    fd.append('file', blob, "{{ $fileName }}");
                    fd.append('type', "{{ $type }}");
                    fd.append('id', "{{ $id }}");
                    fd.append('_token', "{{ csrf_token() }}");
                    
                    // Fetch to Controller
                    fetch("{{ route('excel.editor.save') }}", {
                    method: 'POST',
                    body: fd,
                    headers: {
                        'Accept': 'application/json'
                    }
                })
                .then(async res => {
                    const text = await res.text();
                    try {
                        const json = JSON.parse(text);
                        if (!res.ok) throw new Error(json.message || "HTTP Error " + res.status);
                        return json;
                    } catch (e) {
                        console.error("Parsing response error:", e, "Raw response:", text);
                        if (res.ok) {
                            return { success: true, message: 'File berhasil ditimpa' };
                        }
                        throw new Error("HTTP Error " + res.status);
                    }
                })
                .then(res => {
                    saveText.innerText = 'Save & Overwrite';
                    btnSave.disabled = false;
                    btnSave.classList.remove('opacity-75', 'cursor-not-allowed');

                    if(res.success) {
                        jSuites.notification({
                            title: 'Berhasil!',
                            message: 'Semua Sheet telah sukses dioverwrite di Server.',
                            error: false,
                        });
                    } else {
                        alert("Gagal: " + res.message);
                    }
                })
                .catch(err => {
                    console.error("Fetch Error:", err);
                    saveText.innerText = 'Save & Overwrite';
                    btnSave.disabled = false;
                    btnSave.classList.remove('opacity-75', 'cursor-not-allowed');
                    alert("Error menyimpan data: " + err.message);
                });
            }).catch(e => {
                alert("Gagal mengkompilasi file Excel (ExcelJS): " + e.message);
                saveText.innerText = 'Save & Overwrite';
                btnSave.disabled = false;
                btnSave.classList.remove('opacity-75', 'cursor-not-allowed');
            });
            } catch(e) {
                alert("Gagal memparsing tabel: " + e.message);
                saveText.innerText = 'Save & Overwrite';
                btnSave.disabled = false;
                btnSave.classList.remove('opacity-75', 'cursor-not-allowed');
            }
        }
    </script>
</body>
</html>


