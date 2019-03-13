 <?php  ?>
<script src='/wp-content/themes/llorix-one-lite/js/calc.js'></script>
<!--
<p>Число 1: <input type="text" id='n1'></p>
<p>Число 2: <input type="text" id='n2'></p>
<button onclick="plus()" name="button">+</button>
<button onclick="minus()" name="button">-</button>
<button onclick="multiplay()" name="button">*</button>
<hr>
<p id="out">Ответ:</p>

<hr>

<input type="radio" id='ch1' name="" value=""> Блок
<input type="radio" id='ch2' name="" value=""> Дерево
<button onclick="calc()" name="button">Посчитать</button>
<hr>
<p id="in">0</p>

<input type="radio" id='myradio' name="myradio" value=""> Блок-->

<div class="calc-bl1">
<div style="border: 1px solid black; padding: 10px; margin: 10px;">
<input id="b1" onclick="myFunc ()" type="radio" name="bl" value="1" /> Эконом <br>
<span hidden id="s1">100</span>
<input id="b2" onclick="myFunc ()" type="radio" name="bl" value="2" /> Стандарт <br>
<span hidden id="s2">200</span>
<input id="b3" onclick="myFunc ()" type="radio" name="bl" value="3" /> Премиум <br>
<span hidden id="s3">300</span>
</div>

<div id='st1' class="oldclass" style="border: 1px solid black; padding: 10px; margin: 10px;">
  Стандарт<br>
<input id="b4" onclick="myFunc ()" type="radio" name="st" value="" /> Крыша металл <br>
<span hidden id="s4">100</span>
<input id="b5" onclick="myFunc ()" type="radio" name="st" value="" /> Крыша гибкая <br>
<span hidden id="s5">200</span>

</div>


<div id='pr' class="oldclass" style="border: 1px solid black; padding: 10px; margin: 10px;">
  Премиум<br>
<input id="b6" onclick="myFunc ()" type="radio" name="pr" value="" /> Крыша гибкая<br>
<span hidden id="s6">200</span>
<input id="b7" onclick="myFunc ()" type="radio" name="pr" value="" /> Крыша керамика <br>
<span hidden id="s7">700</span>

</div>

<div class="formInputBlock">
<br />
<b>Итоговая сумма:</b> <span id="r" name="sum">0</span> руб.
</div>
</div>
<div class="calc-bl2">
  <img id="img1" class="img11" src="/wp-content/uploads/2018/11/1.jpg" alt="">
  <img id="img2" class="img1" src="/wp-content/uploads/2018/11/2.jpg" alt="">
  <img id="img3" class="img1" src="/wp-content/uploads/2018/11/3.jpg" alt="">
  <img id="img4" class="img1"src="/wp-content/uploads/2018/11/4.jpg" alt="">
</div>
