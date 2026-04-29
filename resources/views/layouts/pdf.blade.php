<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <style>
        @page {
            margin: 1.5cm;
            footer: html_footer;
        }
        body {
            /* DejaVu Sans is built into DomPDF and provides a very clean, professional look */
            /* It is the best alternative to Inter/SaaS fonts in PDF generation */
            font-family: 'DejaVu Sans', sans-serif;
            color: #1a1523;
            line-height: 1.5;
            font-size: 10pt;
            margin: 0;
            padding: 0;
        }
        
        /* Corporate Header */
        .header {
            margin-bottom: 40px;
        }
        .header-table {
            width: 100%;
            border-bottom: 2px solid #6233a4;
            padding-bottom: 20px;
        }
        .brand-name {
            color: #6233a4;
            font-size: 18pt;
            font-weight: bold;
            letter-spacing: -1px;
            text-transform: uppercase;
        }
        .brand-subtitle {
            color: #6b647c;
            font-size: 9pt;
        }
        .doc-title {
            text-align: right;
            color: #20153a;
        }
        .doc-title h1 {
            margin: 0;
            font-size: 16pt;
            font-weight: bold;
            text-transform: uppercase;
        }
        .doc-meta {
            font-size: 8pt;
            color: #9063cf;
            margin-top: 5px;
        }

        /* Sections */
        .section {
            margin-bottom: 35px;
        }
        .section-header {
            background-color: #f6f3fa;
            border-left: 4px solid #6233a4;
            padding: 8px 15px;
            margin-bottom: 20px;
        }
        .section-title {
            font-size: 11pt;
            font-weight: bold;
            color: #20153a;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin: 0;
        }

        /* Data Grid (Key-Value) */
        .data-grid {
            width: 100%;
            border-collapse: collapse;
        }
        .data-grid td {
            padding: 10px 5px;
            border-bottom: 1px solid #ece6f5;
            vertical-align: top;
        }
        .label {
            font-weight: bold;
            color: #6b647c;
            font-size: 8pt;
            text-transform: uppercase;
            width: 25%;
        }
        .value {
            color: #1a1523;
        }

        /* Main Data Table */
        .content-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .content-table th {
            text-align: left;
            background-color: #ffffff;
            color: #6b647c;
            font-weight: bold;
            font-size: 8pt;
            text-transform: uppercase;
            padding: 12px 10px;
            border-bottom: 2px solid #20153a;
        }
        .content-table td {
            padding: 12px 10px;
            border-bottom: 1px solid #ece6f5;
            font-size: 9pt;
        }
        .content-table tr:nth-child(even) {
            background-color: #fcfaff;
        }

        /* Badges */
        .badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 50px;
            font-size: 7.5pt;
            font-weight: bold;
            text-transform: uppercase;
        }
        .badge-success { background-color: #e6f9f1; color: #10b981; }
        .badge-warning { background-color: #fff8eb; color: #f59e0b; }
        .badge-danger { background-color: #fff1f2; color: #ef4444; }
        .badge-primary { background-color: #f6f3fa; color: #6233a4; }

        /* Summary Box */
        .summary-wrapper {
            margin-top: 30px;
            page-break-inside: avoid;
        }
        .summary-card {
            background-color: #20153a;
            color: #ffffff;
            border-radius: 12px;
            padding: 20px;
        }
        .summary-table {
            width: 100%;
        }
        .summary-col {
            width: 33.33%;
            text-align: center;
        }
        .summary-label {
            display: block;
            font-size: 8pt;
            color: #9063cf;
            text-transform: uppercase;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .summary-value {
            font-size: 16pt;
            font-weight: bold;
        }

        /* Utility */
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .font-bold { font-weight: bold; }
        
        .footer {
            font-size: 8pt;
            color: #b1abbf;
            text-align: center;
            border-top: 1px solid #ece6f5;
            padding-top: 15px;
        }
    </style>
</head>
<body>
    <div class="header">
        <table class="header-table">
            <tr>
                <td style="width: 50%">
                    <div class="brand-name">Demo <span style="color: #9063cf">SaaS</span></div>
                    <div class="brand-subtitle">Soluciones de Gestión Inteligente</div>
                </td>
                <td class="doc-title" style="width: 50%">
                    <h1>@yield('title', 'Reporte')</h1>
                    <div class="doc-meta">
                        EMISIÓN: {{ date('d/m/Y H:i') }}<br>
                        REF: #{{ date('Ymd') }}-{{ rand(100, 999) }}
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <div class="main-content">
        @yield('content')
    </div>

    <htmlpagefooter name="html_footer">
        <div class="footer">
            Documento emitido por Demo SaaS. Prohibida su reproducción total o parcial sin autorización.
            <br>
            Página {PAGENO} de {nbpg}
        </div>
    </htmlpagefooter>
</body>
</html>
