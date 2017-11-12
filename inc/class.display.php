<?php
  class Display {
    var $to_output;
    function output() {
      $html = "<!DOCTYPE html><html lang='en'><head><meta charset='utf-8'><link rel='stylesheet' href='css/default.css'></head>";
      echo filter_var($html, FILTER_DEFAULT);
    }
  }
?>
