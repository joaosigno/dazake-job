<?php

	session_start();
	$id = $_SESSION['id'];
	$title = $_SESSION['posttitle'];
	$link = $_SESSION['postlink'];
	$content = $_SESSION['postcontent'];
	header('Content-disposition: attachment; filename="post.xml"');
	header('Content-type: "text/xml"; charset="utf8"');
	include_once "xml.class.php";

	$xml = new XmlWriterF();
	$xml->push('post');
  $xml->element('post-id', $id);
  $xml->element('post-title', $title);
  $xml->element('post-link', $link);
  $xml->element('post-content', $content);
	$xml->pop();

	print $xml->getXml();
	
?>