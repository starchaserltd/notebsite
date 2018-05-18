<?php
function amazon_com_link($prod,$keys)
{
	$rank="sort=price-asc-rank";
	return "https://www.amazon.com/s/rh=n:13896617011,p_89:".$prod.",p_n_condition-type:2224371011&keywords=+".$keys."&ie=UTF8&".$rank."&low-price=150";
}

function google_com_link($prod,$keys)
{
	return "https://www.google.com/search?cr=countryUS&q=".$prod."+".$keys."+shop";
}

function google_eu_link($prod,$keys)
{
	return "https://www.google.com/search?cr=countryAT|countryBE|countryBG|countryHR|countryCY|countryCZ|countryDK|countryEE|countryFI|countryFR|countryDE|countryGR|countryHU|countryIE|countryIT|countryLV|countryLT|countryLU|countryMT|countryNL|countryPL|countryPT|countryRO|countrySK|countrySI|countryES|countrySE|countryUK&q=".$prod."+".$keys."+buy";
}

function google_uk_link($prod,$keys)
{
	return "https://www.google.co.uk/search?cr=countryUK&q=".$prod."+".$keys."+shop";
}

function amazon_uk_link($prod,$keys)
{
	$rank="sort=price-asc-rank";
	return "https://www.amazon.co.uk/s/?fst=as:off&rh=n:429886031,p_89:".$prod.",p_n_condition-type:12319067031&keywords=+".$keys."&ie=UTF8&".$rank."&low-price=100";
}

function amazon_de_link($prod,$keys)
{
	$rank="relevancerank";
	return "https://www.amazon.de/s/gp/search/?fst=as:off&rh=n:427957031,p_n_condition-type:776950031,p_89:".$prod."&keywords=".$keys."&ie=UTF8&low-price=100&".$rank;
}

function compare_eu_link($prod,$keys)
{
	$matches=array(); if($prod=="Apple"&&preg_match("/(\+|^)(\d{4})(\+|$)/",$keys,$matches)){ $keys=str_replace($matches[0],"+",$keys)."&xf=3310_".$matches[2]; }else{$keys.="&xf=3310_".intval(date("Y")-2);}
	return "https://geizhals.eu/?cat=nb&asd=on&asuch=".$prod."+".$keys."&bpmin=100&sort=p#gh_filterbox";
}

function compare_uk_link($prod,$keys)
{
	$matches=array(); if($prod=="Apple"&&preg_match("/(\+|^)(\d{4})(\+|$)/",$keys,$matches)){ $keys=str_replace($matches[0],"+",$keys)."&xf=3310_".$matches[2]; }else{$keys.="&xf=3310_".intval(date("Y")-2);}
	return "https://skinflint.co.uk/?cat=nb&asd=on&asuch=".$prod."+".$keys."&bpmin=100&sort=p#gh_filterbox";
}

function newegg_link($prod,$keys)
{
	$keys=str_replace("+"," ",$keys);
	return "https://www.newegg.com/Product/ProductList.aspx?Submit=Property&N=100017489 1100858365 4814&SrchInDesc=".$prod." ".$keys."&Page=1&PageSize=36&order=PRICE&LeftPriceRange=100";
}
?>