<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="2.0"
                xmlns:html="http://www.w3.org/TR/REC-html40"
                xmlns:sitemap="http://www.sitemaps.org/schemas/sitemap/0.9"
                xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:output method="html" version="1.0" encoding="UTF-8" indent="yes"/>
    <xsl:template match="/">
        <html xmlns="http://www.w3.org/1999/xhtml">
            <head>
                <title>XML Sitemap - FlyOfAir</title>
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                <meta name="viewport" content="width=device-width, initial-scale=1.0" />
                <style type="text/css">
                    body {
                        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
                        margin: 0;
                        padding: 0;
                        background: #f8f9fa;
                        color: #333;
                        line-height: 1.6;
                    }
                    .container {
                        max-width: 1200px;
                        margin: 0 auto;
                        padding: 20px;
                    }
                    .header {
                        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                        color: white;
                        padding: 40px 0;
                        text-align: center;
                        margin-bottom: 30px;
                        border-radius: 8px;
                        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
                    }
                    .header h1 {
                        margin: 0;
                        font-size: 2.5em;
                        font-weight: 300;
                        text-shadow: 0 2px 4px rgba(0,0,0,0.3);
                    }
                    .header p {
                        margin: 10px 0 0;
                        opacity: 0.9;
                        font-size: 1.1em;
                    }
                    .stats {
                        background: white;
                        padding: 20px;
                        border-radius: 8px;
                        margin-bottom: 30px;
                        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
                        display: flex;
                        justify-content: space-around;
                        flex-wrap: wrap;
                    }
                    .stat-item {
                        text-align: center;
                        margin: 10px;
                    }
                    .stat-number {
                        font-size: 2em;
                        font-weight: bold;
                        color: #667eea;
                    }
                    .stat-label {
                        color: #666;
                        font-size: 0.9em;
                        text-transform: uppercase;
                        letter-spacing: 1px;
                    }
                    .table-container {
                        background: white;
                        border-radius: 8px;
                        overflow: hidden;
                        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
                    }
                    table {
                        width: 100%;
                        border-collapse: collapse;
                    }
                    th {
                        background: #f8f9fa;
                        color: #495057;
                        padding: 15px 20px;
                        text-align: left;
                        font-weight: 600;
                        font-size: 0.9em;
                        text-transform: uppercase;
                        letter-spacing: 0.5px;
                        border-bottom: 2px solid #dee2e6;
                    }
                    td {
                        padding: 15px 20px;
                        border-bottom: 1px solid #f1f3f4;
                        vertical-align: top;
                    }
                    tr:nth-child(even) {
                        background-color: #f8f9fa;
                    }
                    tr:hover {
                        background-color: #e3f2fd;
                        transition: background-color 0.2s ease;
                    }
                    .url-link {
                        color: #0066cc;
                        text-decoration: none;
                        font-weight: 500;
                    }
                    .url-link:hover {
                        text-decoration: underline;
                        color: #004499;
                    }
                    .priority {
                        font-weight: 600;
                        color: #28a745;
                    }
                    .changefreq {
                        text-transform: capitalize;
                        color: #6c757d;
                    }
                    .lastmod {
                        color: #6c757d;
                        font-size: 0.9em;
                    }
                    .footer {
                        text-align: center;
                        margin-top: 30px;
                        color: #6c757d;
                        font-size: 0.9em;
                    }
                    @media (max-width: 768px) {
                        .container {
                            padding: 10px;
                        }
                        .header {
                            padding: 20px 0;
                        }
                        .header h1 {
                            font-size: 2em;
                        }
                        .stats {
                            flex-direction: column;
                        }
                        .stat-item {
                            margin: 5px 0;
                        }
                        th, td {
                            padding: 10px;
                            font-size: 0.9em;
                        }
                        .url-link {
                            word-break: break-all;
                        }
                    }
                </style>
            </head>
            <body>
                <div class="container">
                    <div class="header">
                        <h1>XML Sitemap</h1>
                        <p>FlyOfAir - Your Trusted Travel Partner</p>
                    </div>

                    <div class="stats">
                        <div class="stat-item">
                            <div class="stat-number"><xsl:value-of select="count(sitemap:urlset/sitemap:url)"/></div>
                            <div class="stat-label">Total URLs</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number"><xsl:value-of select="count(sitemap:urlset/sitemap:url[sitemap:priority='1.00'])"/></div>
                            <div class="stat-label">High Priority</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number"><xsl:value-of select="count(sitemap:urlset/sitemap:url[sitemap:priority='0.80'])"/></div>
                            <div class="stat-label">Medium Priority</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number"><xsl:value-of select="count(sitemap:urlset/sitemap:url[sitemap:priority='0.50'])"/></div>
                            <div class="stat-label">Low Priority</div>
                        </div>
                    </div>

                    <div class="table-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>URL</th>
                                    <th>Priority</th>
                                    <th>Change Frequency</th>
                                    <th>Last Modified</th>
                                </tr>
                            </thead>
                            <tbody>
                                <xsl:for-each select="sitemap:urlset/sitemap:url">
                                    <tr>
                                        <td>
                                            <a class="url-link" href="{sitemap:loc}"><xsl:value-of select="sitemap:loc"/></a>
                                        </td>
                                        <td class="priority"><xsl:value-of select="sitemap:priority"/></td>
                                        <td class="changefreq"><xsl:value-of select="sitemap:changefreq"/></td>
                                        <td class="lastmod"><xsl:value-of select="sitemap:lastmod"/></td>
                                    </tr>
                                </xsl:for-each>
                            </tbody>
                        </table>
                    </div>

                    <div class="footer">
                        <p>This sitemap was automatically generated on <xsl:value-of select="format-dateTime(current-dateTime(), '[Y]-[M01]-[D01] [H01]:[m01]:[s01]')"/> UTC</p>
                        <p>© 2024 FlyOfAir. All rights reserved.</p>
                    </div>
                </div>
            </body>
        </html>
    </xsl:template>
</xsl:stylesheet>