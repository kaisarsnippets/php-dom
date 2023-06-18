<?php
// DOM manager
/**
 * @requires: php-dom
 * */
Class Dom {
    public $Element = null;

    public function __construct($elm = null) {
       $elm && $this->Element = $elm;
    }

    // Create Document
    public function setDoc($str = '') {
        !$str && $str =
        "<!DOCTYPE html>
        <html></html>";
        $elm = new DOMDocument();
        $elm->loadHTML($str);
        $this->Element =
        $elm->documentElement;
        return $this;
    }

    // Get Document
    public function getDoc() {
        $elm = $this->Element;
        property_exists($elm, 'ownerDocument')
        && $elm->ownerDocument &&
        $doc = $elm->ownerDocument;
        return new self($doc);
    }

    // Add node
    public function setNode($tag = 'div'){
        $tag = strtolower($tag);
        $doc = $this->getDoc()->Element;
        $elm = $doc->createElement($tag);
        $pnt = $this->Element;
        $pnt->appendChild($elm);
        return new self($elm);
    }

    // Empty node
    public function emptyNode() {
        $elm = $this->Element;
        $elm->nodeValue = '';
        return new self($elm);
    }

    // Add attribute
    public function setAttr($k, $v){
        $elm = $this->Element;
        $elm->setAttribute($k, $v);
        return $this;
    }

    // Add HTML content
    public function setHTML($htm = ''){
        $elm = $this->Element;
        $doc = $this->getDoc()->Element;
        $frg = $doc->createDocumentFragment();
        $frg->appendXML($htm);
        $elm->appendChild($frg);
        return $this;
    }

    // Add text content
    public function setText($txt = ''){
        $elm = $this->Element;
        $doc = $this->getDoc()->Element;
        $frg = $doc->createTextNode($txt);
        $elm->appendChild($frg);
        return $this;
    }

    // Get HTML string
    public function getHTML() {
        $elm = $this->Element;
        if ($elm instanceof DOMNode) {
            $dom = new DOMDocument();
            $elm = $dom->importNode($elm, true);
            $dom->appendChild($elm);
            return $dom->saveHTML();
        } else {
            $doc = $this->getDoc();
            $doc = $doc->Element;
            return $doc->saveHTML();
        }
    }

    // Get parent
    public function parent() {
        $elm = $this->Element;
        $pnt = $elm->parentNode;
        $pnt && $pnt = new self($pnt);
        return $pnt;
    }

    // Find elements (XPath)
    public function find($pth = ''){
        $elm = $this->Element;
        $doc = $this->getDoc();
        $doc = $doc->Element;
        $xpt = new DOMXPath($doc);
        return $xpt->query($pth, $elm);
    }
}
