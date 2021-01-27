<?php
namespace KC;

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
        $doc = $this->Element;
        property_exists($elm, 'ownerDocument')
        && $elm->ownerDocument &&
        $doc = $elm->ownerDocument;
        return new self($doc);
    }
    
    // Add element
    public function add($tag = 'div'){
        $tag = strtolower($tag);
        $doc = $this->getDoc()->Element;
        $elm = $doc->createElement($tag);
        $pnt = $this->Element;
        $pnt->appendChild($elm);
        return new self($elm);
    }
    
    // Add attribute
    public function atr($k, $v){
        $elm = $this->Element;
        $elm->setAttribute($k, $v);
        return $this;
    }
    
    // Add HTML content
    public function htm($htm = ''){
        $elm = $this->Element;
        $doc = $this->getDoc()->Element;
        $frg = $doc->createDocumentFragment();
        $frg->appendXML($htm);
        $elm->appendChild($frg);
        return $this;
    }
    
    // Add text content
    public function txt($txt = ''){
        $elm = $this->Element;
        $doc = $this->getDoc()->Element;
        $frg = $doc->createTextNode($txt);
        $elm->appendChild($frg);
        return $this;
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
    
    // Get document string
    public function output() {
        $doc = $this->getDoc();
        $doc = $doc->Element;
        return $doc->saveHTML();
    }
}
