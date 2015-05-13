<?php
/*  libhdate - Hebrew calendar library
 *
 *  Copyright (C) 2015 Yaacov Zamir <kobi.zamir@gmail.com>
 *  
 *  This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

/**
 @brief Return string of hebrew parasha.

 @param reading string number
 @return the name of parasha 1. Bereshit etc..
 (55 trow 61 are joined strings e.g. Vayakhel Pekudei)
*/
function
hdate_get_parasha_name ($reading)
{
  static $strings = [
  "none",    "בראשית",    "נח",
   "לך לך",    "וירא",    	"חיי שרה",
   "תולדות",    "ויצא",    	"וישלח",
   "וישב",    "מקץ",    	"ויגש",    /* 11 */
   "ויחי",    "שמות",    	"וארא",
   "בא",    	"בשלח",    	"יתרו",
   "משפטים",    "תרומה",    "תצוה",    /* 20 */
   "כי תשא",    "ויקהל",    "פקודי",
   "ויקרא",    "צו",    	"שמיני",
   "תזריע",    "מצורע",    "אחרי מות",
   "קדושים",    "אמור",    	"בהר",    /* 32 */
   "בחוקתי",    "במדבר",    "נשא",
   "בהעלתך",    "שלח",    	"קרח",
   "חקת",    	"בלק",    	"פנחס",    /* 41 */
   "מטות",    "מסעי",    	"דברים",
   "ואתחנן",    "עקב",    	"ראה",
   "שופטים",    "כי תצא",    "כי תבוא",    /* 50 */
   "נצבים",    "וילך",    	"האזינו",
   "וזאת הברכה",	/* 54 */
   "ויקהל-פקודי",	"תזריע-מצורע",	"אחרי מות-קדושים",
   "בהר-בחוקתי",	"חוקת-בלק",    "מטות מסעי",
   "נצבים-וילך"];
 
  return $strings[$reading];
}