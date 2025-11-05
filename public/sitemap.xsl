<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="2.0"
                xmlns:html="http://www.w3.org/TR/REC-html40"
                xmlns:sitemap="http://www.sitemaps.org/schemas/sitemap/0.9"
                xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:output method="html" version="1.0" encoding="UTF-8" indent="yes"/>
    <xsl:template match="/">
        <html xmlns="http://www.w3.org/1999/xhtml">
            <head>
                <title>XML Sitemap</title>
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                <style type="text/css">
                    body {
                        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif;
                        color: #444;
                        max-width: 1200px;
                        margin: 0 auto;
                        padding: 20px;
                    }
                    table {
                        width: 100%;
                        border-collapse: collapse;
                        margin: 20px 0;
                    }
                    th {
                        background-color: #f4f4f4;
                        text-align: left;
                        padding: 12px;
                        font-weight: bold;
                        border-bottom: 1px solid #ddd;
                    }
                    td {
                        padding: 12px;
                        border-bottom: 1px solid #eee;
                    }
                    tr:hover {
                        background-color: #f9f9f9;
                    }
                    h1 {
                        color: #333;
                        margin: 0 0 20px;
                    }
                    a {
                        color: #0066cc;
                        text-decoration: none;
                    }
                    a:hover {
                        text-decoration: underline;
                    }
                    .desc {
                        margin: 0 0 20px;
                        color: #666;
                    }
                </style>
            </head>
            <body>
                <h1>XML Sitemap</h1>
                <p class="desc">This sitemap contains <xsl:value-of select="count(sitemap:urlset/sitemap:url)"/> URLs.</p>
                <table>
                    <tr>
                        <th>URL</th>
                        <th>Priority</th>
                        <th>Change Frequency</th>
                        <th>Last Modified</th>
                    </tr>
                    <xsl:for-each select="sitemap:urlset/sitemap:url">
                        <tr>
                            <td>
                                <a href="{sitemap:loc}"><xsl:value-of select="sitemap:loc"/></a>
                            </td>
                            <td><xsl:value-of select="sitemap:priority"/></td>
                            <td><xsl:value-of select="sitemap:changefreq"/></td>
                            <td><xsl:value-of select="sitemap:lastmod"/></td>
                        </tr>
                    </xsl:for-each>
                </table>
            </body>
        </html>
    </xsl:template>
</xsl:stylesheet>