<?php

function formatUang($val)
{
  return number_format(floatval($val), 2, ",", ".");
}

function inputTypeHidden($name, $value)
{
  return '<input type="hidden" name="'.$name.'" value= "'.$value.'" id="'.$name.'" />';
}

function inputTypeUang($name, $value, $placeholder = '', $style = 'style="text-align:right;"')
{
  $uangx = explode(",", formatUang($value));
  $uang = floatval($value) != 0 ? $uangx[0] : "";
  $uangk = intval($uangx[1]) > 0 ? "," .$uangx[1] : "";
  return '<input type="text" onkeypress="return isNumberKey(event)" onkeyup="inputCurrency(`'.$name.'`)" name="'.$name.'_Uang" id="'.$name.'_Uang" value="'.$uang.$uangk. '" placeholder="'.$placeholder.'" '.$style.' />' . inputTypeHidden($name, $value);
}
