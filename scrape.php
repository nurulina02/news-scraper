<?php
header("Content-Type: application/json");

// the verge website
$url = "https://www.theverge.com/";

$html = file_get_contents($url);

// load html into DOM
$dom = new DOMDocument();
libxml_use_internal_errors(true);
$dom-> loadHTML($html);
libxml_clear_errors();

$articles = [];
$seenTitles = []; // additional, to store titles to avoid duplicates

// extract article titles and dates
$xpath = new DOMXPath($dom);
$articleNodes = $xpath->query("//a[contains(@class, '_1lkmsmo1')]"); // selecting titles
$dateNodes = $xpath->query("//span[contains(@class, 'duet--article--timestamp')]/time"); // Selecting dates




foreach ($articleNodes as $index => $node) {
  $title = trim($node->textContent);
  $link = "https://theverge.com" . $node->getAttribute("href"); // add base URL
  $dateNode = $dateNodes->item($index); // Get corresponding date node

  if ($dateNode) {
    $dateText = $dateNode->getAttribute("datetime"); // get datetime attribute
    $articleYear = date("Y", strtotime($dateText)); // Extract year

    // to display only articles from 2022 onwards and avoid duplication
    if ($articleYear >= 2022 && !isset($seenTitles[$title])) {
      $articles[] = ["title" => $title, "link" => $link, "date" => $dateText];
      $seenTitles[$title] = true; // Mark as seen
    }
  }
}

// return JSON
echo json_encode($articles);
?>