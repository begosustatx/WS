<?xml version="1.0"?>
<xsl:stylesheet version="1.0"
xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:template match="/">
<HTML>
	<BODY>
		<h2>Galderak</h2>
		<TABLE border="1">
			<TR>
				<TH>Testua</TH>
				<TH>Erantzun zuzena</TH>
				<TH>Erantzun okerrak</TH>
				<TH>Zailtasuna</TH>
				<TH>Arloa</TH>
			</TR>
			<xsl:for-each select="/assessmentItems/assessmentItem" >
				<TR>
					<TD><FONT SIZE="2" COLOR="red" FACE="Verdana">
						<xsl:value-of select="itemBody/p"/> <BR/>
						</FONT>
					</TD>
					<TD><FONT SIZE="2" COLOR="orange" FACE="Verdana">
						<xsl:value-of select="correctResponse"/> <BR/>
						</FONT>
					</TD>
					<TD>
						<FONT SIZE="2" COLOR="pink" FACE="Verdana">
						<xsl:value-of select="incorrectResponses/value[1]"/> <BR/>
						<xsl:value-of select="incorrectResponses/value[2]"/> <BR/>
						<xsl:value-of select="incorrectResponses/value[3]"/> <BR/>
						</FONT>
					</TD>
					<TD><FONT SIZE="2" COLOR="green" FACE="Verdana">
						<xsl:value-of select="@complexity"/> <BR/>
						</FONT>
					</TD>
						<TD><FONT SIZE="2" COLOR="blue" FACE="Verdana">
						<xsl:value-of select="@subject"/> <BR/>
						</FONT>
					</TD>
				</TR>
			</xsl:for-each>
		</TABLE>
	</BODY>
</HTML></xsl:template>
</xsl:stylesheet>