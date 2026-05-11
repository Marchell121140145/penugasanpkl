
$xmlPath = "c:\laragon\www\penugasanpkl\draft TA\extracted\word\document.xml"
$outputPath = "c:\laragon\www\penugasanpkl\draft TA\extracted_text.txt"

[xml]$xml = Get-Content $xmlPath
$ns = New-Object System.Xml.XmlNamespaceManager($xml.NameTable)
$ns.AddNamespace("w", "http://schemas.openxmlformats.org/wordprocessingml/2006/main")

$nodes = $xml.SelectNodes("//w:t", $ns)
$text = ""
foreach ($node in $nodes) {
    $text += $node.InnerText + "`n"
}

$text | Out-File $outputPath
