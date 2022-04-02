<?php
class Footer
{
  public static function displayFooter($content = '')
  {
    $websiteDate = getdate();
    if ($content === 'About Page') {
      $reference = '<p style="text-align:left; font-size:20px;"><a href="http://www.pixelsagas.com" target="_blank">Reference:Courtesy of Pixel Sagas Freeware Fonts</a></p>';
    } else {
      $reference = '';
    }
    echo '<footer><br>
             ' . $reference . ' Copyright &copy; ' . $websiteDate['year'] .
      '</footer>';
  }
}
