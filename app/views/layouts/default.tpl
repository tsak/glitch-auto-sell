<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Glitch Autosell</title>
  <meta name="description" content="" />
  <meta name="keywords" content="" />
  {$revision = 1}
  {$html->css("site.css?$revision")}
  {$javascript->link('jquery-1.6.2.min.js')}
  {$javascript->link('site.js')}
</head>
<body>
  {$content_for_layout}
</body>
</html>
{$view->element('sqldump')}
