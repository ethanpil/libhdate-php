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
 @brief Return number of hebrew $holyday.

 @param h The hdate_struct of the date to use.
 @param diaspora if True give diaspora $holydays
 @return the number of $holyday.
*/
function
hdate_get_holyday ($h, $diaspora = false)
{
  $holyday = 0;

  /* $holydays table */
  static $holydays_table = 
  [
    [  /* Tishrey */
      1, 2, 3, 3, 0, 0, 0, 0, 37, 4,
      0, 0, 0, 0, 5, 31, 6, 6, 6, 6,
      7, 27, 8, 0, 0, 0, 0, 0, 0, 0],
    [  /* Heshvan */
      0, 0, 0, 0, 0, 0, 0, 0, 0, 35,
      35, 35, 0, 0, 0, 0, 0, 0, 0, 0,
      0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
    [  /* Kislev */
      0, 0, 0, 0, 0, 0, 0, 0, 0, 0,
      0, 0, 0, 0, 0, 0, 0, 0, 0, 0,
      0, 0, 0, 0, 9, 9, 9, 9, 9, 9],
    [  /* Tevet */
      9, 9, 9, 0, 0, 0, 0, 0, 0, 10,
      0, 0, 0, 0, 0, 0, 0, 0, 0, 0,
      0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
    [  /* Shvat */
      0, 0, 0, 0, 0, 0, 0, 0, 0, 0,
      0, 0, 0, 0, 11, 0, 0, 0, 0, 0,
      0, 0, 0, 0, 0, 0, 0, 0, 0, 33],
    [  /* Adar */
      0, 0, 0, 0, 0, 0, 0, 0, 0, 0,
      12, 0, 12, 13, 14, 0, 0, 0, 0, 0,
      0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
    [  /* Nisan */
      0, 0, 0, 0, 0, 0, 0, 0, 0, 0,
      0, 0, 0, 0, 15, 32, 16, 16, 16, 16,
      28, 29, 0, 0, 0, 24, 24, 24, 0, 0],
    [  /* Iyar */
      0, 17, 17, 17, 17, 17, 0, 0, 0, 0,
      0, 0, 0, 0, 0, 0, 0, 18, 0, 0,
      0, 0, 0, 0, 0, 0, 0, 26, 0, 0],
    [  /* Sivan */
      0, 0, 0, 0, 19, 20, 30, 0, 0, 0,
      0, 0, 0, 0, 0, 0, 0, 0, 0, 0,
      0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
    [  /* Tamuz */
      0, 0, 0, 0, 0, 0, 0, 0, 0, 0,
      0, 0, 0, 0, 0, 0, 21, 21, 0, 0,
      0, 0, 0, 0, 0, 0, 0, 0, 36, 36],
    [  /* Av */
      0, 0, 0, 0, 0, 0, 0, 0, 22, 22,
      0, 0, 0, 0, 23, 0, 0, 0, 0, 0,
      0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
    [  /* Elul */
      0, 0, 0, 0, 0, 0, 0, 0, 0, 0,
      0, 0, 0, 0, 0, 0, 0, 0, 0, 0,
      0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
    [  /* Adar 1 */
      0, 0, 0, 0, 0, 0, 0, 0, 0, 0,
      0, 0, 0, 0, 0, 0, 0, 0, 0, 0,
      0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
    [  /* Adar 2 */
      0, 0, 0, 0, 0, 0, 0, 0, 0, 0,
      12, 0, 12, 13, 14, 0, 0, 0, 0, 0,
      0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
  ];
  
  /* sanity check */
  if ($h->hd_mon < 1 || $h->hd_mon > 14 || $h->hd_day < 1 || $h->hd_day > 30)
    return 0;
  
  $holyday = $holydays_table[$h->hd_mon - 1][$h->hd_day - 1];
  
  /* if tzom on sat delay one day */
  /* tzom gdalyaho on sat */
  if (($holyday == 3) && ($h->hd_dw == 7 || ($h->hd_day == 4 && $h->hd_dw !=1)))
    $holyday = 0;
  /* 17 of Tamuz on sat */
  if (($holyday == 21) && (($h->hd_dw == 7) || ($h->hd_day == 18 && $h->hd_dw != 1)))
    $holyday = 0;
  /* 9 of Av on sat */
  if (($holyday == 22) && (($h->hd_dw == 7) || ($h->hd_day == 10 && $h->hd_dw != 1)))
    $holyday = 0;
  
  /* Hanukah in a long year */
  if (($holyday == 9) && ($h->hd_size_of_year % 10 != 3) && ($h->hd_day == 3))
    $holyday = 0;
  
  /* if tanit ester on sat mov to Thu */
  if (($holyday == 12) && (($h->hd_dw == 7) || ($h->hd_day == 11 && $h->hd_dw != 5)))
    $holyday = 0;
  
  /* yom yerushalym after 68 */
  if ($holyday == 26)
  {
    if ($h->gd_year < 1968)
      $holyday = 0;
  }
  
  /* yom ha azmaot and yom ha zicaron */
  if ($holyday == 17)
  {
    if ($h->gd_year < 1948)
      $holyday = 0;
    else if ($h->gd_year < 2004)
    {
      if (($h->hd_day == 3) && ($h->hd_dw == 5))
        $holyday = 17;
      else if (($h->hd_day == 4) && ($h->hd_dw == 5))
        $holyday = 17;
      else if (($h->hd_day == 5) && ($h->hd_dw != 6 && $h->hd_dw != 7))
        $holyday = 17;
      else if (($h->hd_day == 2) && ($h->hd_dw == 4))
        $holyday = 25;
      else if (($h->hd_day == 3) && ($h->hd_dw == 4))
        $holyday = 25;
      else if (($h->hd_day == 4) && ($h->hd_dw != 5 && $h->hd_dw != 6))
        $holyday = 25;
      else
        $holyday = 0;
    }
    else
    {
      if (($h->hd_day == 3) && ($h->hd_dw == 5))
        $holyday = 17;
      else if (($h->hd_day == 4) && ($h->hd_dw == 5))
        $holyday = 17;
      else if (($h->hd_day == 6) && ($h->hd_dw == 3))
        $holyday = 17;
      else if (($h->hd_day == 5) && ($h->hd_dw != 6 && $h->hd_dw != 7 && $h->hd_dw != 2))
        $holyday = 17;
      else if (($h->hd_day == 2) && ($h->hd_dw == 4))
        $holyday = 25;
      else if (($h->hd_day == 3) && ($h->hd_dw == 4))
        $holyday = 25;
      else if (($h->hd_day == 5) && ($h->hd_dw == 2))
        $holyday = 25;
      else if (($h->hd_day == 4) && ($h->hd_dw != 5 && $h->hd_dw != 6 && $h->hd_dw != 1))
        $holyday = 25;
      else
        $holyday = 0;
    }
  }
  
  /* yom ha shoaa, on years after 1958 */
  if ($holyday == 24)
  {
    if ($h->gd_year < 1958)
      $holyday = 0;
    else
    {
      if (($h->hd_day == 26) && ($h->hd_dw != 5))
        $holyday = 0;
      if (($h->hd_day == 28) && ($h->hd_dw != 2))
        $holyday = 0;
      if (($h->hd_day == 27) && ($h->hd_dw == 6 || $h->hd_dw == 1))
        $holyday = 0;
    }
  }
  
  /* Rabin day, on years after 1997 */
  if ($holyday == 35)
  {
    if ($h->gd_year < 1997)
      $holyday = 0;
    else
    {
      if (($h->hd_day == 10 || $h->hd_day == 11) && ($h->hd_dw != 5))
        $holyday = 0;
      if (($h->hd_day == 12) && ($h->hd_dw == 6 || $h->hd_dw == 7))
        $holyday = 0;
    }
  }
  
  /* Zhabotinsky day, on years after 2005 */
  if ($holyday == 36)
  {
    if ($h->gd_year < 2005)
      $holyday = 0;
    else
    {
      if (($h->hd_day == 30) && ($h->hd_dw != 1))
        $holyday = 0;
      if (($h->hd_day == 29) && ($h->hd_dw == 7))
        $holyday = 0;
    }
  }
  
  /* diaspora holidays */
  
  /* simchat tora only in diaspora in israel just one day shmini+simchat tora */
  if ($holyday == 8 && !diaspora)
    $holyday = 0;
  
  /* sukkot II holiday only in diaspora */
  if ($holyday == 31 && !diaspora)
    $holyday = 6;

  /* pesach II holiday only in diaspora */
  if ($holyday == 32 && !diaspora)
    $holyday = 16;
  
  /* shavot II holiday only in diaspora */
  if ($holyday == 30 && !diaspora)
    $holyday = 0;
  
  /* pesach VIII holiday only in diaspora */
  if ($holyday == 29 && !diaspora)
    $holyday = 0;
  
  return $holyday;
}

/**
 @brief Return the day in the omer of the given date

 @param h The hdate_struct of the date to use.
 @return The day in the omer, starting from 1 (or 0 if not in sfirat ha omer)
*/
function
hdate_get_omer_day($h)
{
  $omer_day = 0;
  $sixteen_nissan = new Hdate();
  
  $sixteen_nissan->set_hdate(16, 7, $h->hd_year);
  $omer_day = $h->hd_jd - $sixteen_nissan->hd_jd + 1;

  if (($omer_day > 49) || ($omer_day < 0)) 
    $omer_day = 0;

  return $omer_day;
}

