<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <title>Z80 instruction set - ClrHome</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style type="text/css">
      body > div {
        width: 960px;
        margin: 0 auto 200px auto;
        font-family: Verdana;
        font-size: 24px;
      }
      form {
        margin-top: 2em;
        font-size: 0.6em;
      }
      form span {
        display: inline-block;
        position: relative;
        top: -0.5em;
      }
      #search {
        font-size: 1em;
        font-family: Verdana;
        width: 640px;
      }
      h3, p {
        text-align: center;
      }
      table {
        table-layout: fixed;
        width: 960px;
      }
      table, .tooltip {
        font-size: 0.5em;
      }
      th {
        color: #999;
      }
      tr:first-child {
        height: 2em;
      }
      td {
        font-family: "Courier New", Courier;
        font-weight: bold;
        background-color: #ccc;
        color: #333;
        padding: 6px;
        word-wrap: break-word;
      }
      .un {
        background-color: #f66;
      }
      .ln {
        padding: 0;
      }
      .hr {
        background-color: #000;
        color: #666;
      }
      th, .bk {
        background-color: #333;
      }
      .hd, td:hover, td a {
        background-color: #999;
        color: #000;
      }
      td:first-child {
        width: 1em;
        background-color: transparent;
      }
      td a {
        display: block;
        padding: 6px;
        font-family: Verdana;
        text-align: center;
      }
      td a:hover, .tooltip {
        background-color: #fff;
        text-decoration: none;
      }
      .tooltip {
        position: absolute;
        width: 160px;
        border: 3px solid #000;
        padding: 6px;
      }
      #banner {
        position: fixed;
        top: 0;
        right: 50%;
        z-index: 9;
        width: 200px;
        margin-right: -420px;
        font-family: 'Times New Roman', Times, serif;
      }
      #banner > a {
        display: block;
        border: 2px solid #aa8;
        border-top: 0;
        padding: 8px 4px;
        background: #cca;
        color: #331;
        text-decoration: none;
        text-align: center;
        font-style: italic;
        -webkit-transition: background-color 200ms;
        -o-transition: background-color 200ms;
        -ms-transition: background-color 200ms;
        -moz-transition: background-color 200ms;
        transition: background-color 200ms;
      }
      #banner > a:hover {
        background: #eec;
      }
      #banner span {
        display: block;
        font-size: 0.6em;
      }
      #banner img {
        display: block;
        width: 100%;
        border: 0;
      }
      #banner cite {
        display: block;
        padding: 4px 8px;
        background: #aa8;
        color: #ddc;
        font-style: normal;
      }
      #banner cite img {
        float: right;
        width: 96px;
        opacity: 0.4;
        -ms-filter: 'progid:DXImageTransform.Microsoft.Alpha(Opacity=40)';
        filter: alpha(opacity=40);
        -webkit-transition: opacity 200ms;
        -o-transition: opacity 200ms;
        -ms-transition: opacity 200ms;
        -moz-transition: opacity 200ms;
        transition: opacity 200ms;
      }
      #banner cite a:hover img {
        opacity: 0.1;
        -ms-filter: 'progid:DXImageTransform.Microsoft.Alpha(Opacity=10)';
        filter: alpha(opacity=10);
      }
    </style>
    <link rel="shortcut icon" href="/favicon.ico" />
    <script type="text/javascript" src="/lib/js/jquery.js"></script>
    <script type="text/javascript" src="/lib/js/ga.js"></script>
    <script type="text/javascript">// <![CDATA[
      function rehash() {
        window.location.hash = $('#search').val();
      }

      function hashchange() {
        var hash = window.decodeURIComponent(window.location.hash).slice(1);

        if (hash != $('#search').val()) {
          $('#search').val(hash);
        }

        $('td').each(function() {
          if ($(this).text().indexOf(hash) == -1) {
            $(this).addClass('bk');
          } else {
            $(this).removeClass('bk');
          }
        });
      }

      function detip() {
        $('.tooltip').remove();
      }

      $(function() {
        var keyup = 0;

        $('th').hover(function() {
          $(this).addClass('hr');
          ($(this).index() ? $(this).parent().parent().find('td:nth-child(' + ($(this).index() + 1).toString() + ')') : $(this).siblings()).addClass('hd');
        }, function() {
          $(this).removeClass('hr');
          ($(this).index() ? $(this).parent().parent().find('td:nth-child(' + ($(this).index() + 1).toString() + ')') : $(this).siblings()).removeClass('hd');
        });

        $('#search').keyup(function(e) {
          clearTimeout(keyup);
          keyup = setTimeout(rehash, 400);
        });

        $('a').click(function() {
          $(window).scrollTop($($(this).attr('href')).position().top);
          return false;
        });

        $('td:not(:has(\'a\')):not(:first-child)').mouseover(function(e) {
          var desc = '';
          var val = $(this).attr('axis').split('|');
          var flags = ['C', 'N', 'P/V', 'H', 'Z', 'S'];

          for (i = 0; i < 6; i++) {
            desc += '<br><b>' + flags[i] + ':</b> ';

            switch (val[0].charAt(i)) {
              case '-':
                desc += 'unaffected';
                break;
              case '+':
                desc += 'affected as defined';
                break;
              case 'P':
                desc += 'detects parity';
                break;
              case 'V':
                desc += 'detects overflow';
                break;
              case '1':
                desc += 'set';
                break;
              case '0':
                desc += 'reset';
                break;
              case '*':
                desc += 'exceptional';
                break;
              default:
                desc += 'unknown';
            }
          }

          detip();
          $('<div class="tooltip"><b>Opcode:</b> ' + $(this).closest('table').attr('title') + '0123456789ABCDEF'.charAt($(this).parent().index() - 1) + '0123456789ABCDEF'.charAt($(this).index() - 1) + '<br><b>Size (bytes):</b> ' + val[1] + '<br><b>Time (clock cycles):</b> ' + val[2] + desc + '<br>' + val[3] + '</div>').css({'left': e.pageX + 10, 'top': e.pageY + 20}).appendTo('body > div');
        }).mousemove(function(e) {
          $('.tooltip').css({'left': e.pageX + 10, 'top': e.pageY + 20});
        });

        $('#banner').mouseenter(function() {
          $(this).stop().animate({top: 0});
        }).mouseleave(function() {
          $(this).stop().animate({top: -120});
        });

        $(window).keydown(function(e) {
          if (e.keyCode == 191) {
            $('#search').focus().select();
            return false;
          }
        });

        $('table').mouseout(detip);
        window.onhashchange = hashchange;
        hashchange();
      });
    // ]]></script>
  </head>
  <body>
    <div>
      <form action="https://www.paypal.com/donate" method="post" target="_top">
        <div>
          <span>Your contributions help keep our services running!</span>
          <input type="hidden" name="business" value="T3NJS3T45WMFC" />
          <input type="hidden" name="item_name" value="ClrHome" />
          <input type="hidden" name="currency_code" value="USD" />
          <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_LG.gif" border="0" name="submit" title="PayPal - The safer, easier way to pay online!" alt="Donate with PayPal button" />
          <img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1" />
        </div>
      </form>
      <p>Type here to search: <input type="text" id="search" /></p>
      <h3 id="table1">Main instructions</h3>
      <table title="">
        <tr>
          <td></td>
          <th>0</th>
          <th>1</th>
          <th>2</th>
          <th>3</th>
          <th>4</th>
          <th>5</th>
          <th>6</th>
          <th>7</th>
          <th>8</th>
          <th>9</th>
          <th>A</th>
          <th>B</th>
          <th>C</th>
          <th>D</th>
          <th>E</th>
          <th>F</th>
        </tr>
        <tr>
          <th>0</th>
          <td axis="------|1|4|No operation is performed.">nop</td>
          <td axis="------|3|10|Loads ** into bc.">ld bc,**</td>
          <td axis="------|1|7|Stores a into the memory location pointed to by bc.">ld (bc),a</td>
          <td axis="------|1|6|Adds one to bc.">inc bc</td>
          <td axis="-+V+++|1|4|Adds one to b.">inc b</td>
          <td axis="-+V+++|1|4|Subtracts one from b.">dec b</td>
          <td axis="------|2|7|Loads * into b.">ld b,*</td>
          <td axis="+0-0--|1|4|The contents of a are rotated left one bit position. The contents of bit 7 are copied to the carry flag and bit 0.">rlca</td>
          <td axis="------|1|4|Exchanges the 16-bit contents of af and af'.">ex af,af'</td>
          <td axis="++-+--|1|11|The value of bc is added to hl.">add hl,bc</td>
          <td axis="------|1|7|Loads the value pointed to by bc into a.">ld a,(bc)</td>
          <td axis="------|1|6|Subtracts one from bc.">dec bc</td>
          <td axis="-+V+++|1|4|Adds one to c.">inc c</td>
          <td axis="-+V+++|1|4|Subtracts one from c.">dec c</td>
          <td axis="------|2|7|Loads * into c.">ld c,*</td>
          <td axis="+0-0--|1|4|The contents of a are rotated right one bit position. The contents of bit 0 are copied to the carry flag and bit 7.">rrca</td>
        </tr>
        <tr>
          <th>1</th>
          <td axis="------|2|13/8|The b register is decremented, and if not zero, the signed value * is added to pc. The jump is measured from the start of the instruction opcode.">djnz *</td>
          <td axis="------|3|10|Loads ** into de.">ld de,**</td>
          <td axis="------|1|7|Stores a into the memory location pointed to by de.">ld (de),a</td>
          <td axis="------|1|6|Adds one to de.">inc de</td>
          <td axis="-+V+++|1|4|Adds one to d.">inc d</td>
          <td axis="-+V+++|1|4|Subtracts one from d.">dec d</td>
          <td axis="------|2|7|Loads * into d.">ld d,*</td>
          <td axis="+0-0--|1|4|The contents of a are rotated left one bit position. The contents of bit 7 are copied to the carry flag and the previous contents of the carry flag are copied to bit 0.">rla</td>
          <td axis="------|2|12|The signed value * is added to pc. The jump is measured from the start of the instruction opcode.">jr *</td>
          <td axis="++-+--|1|11|The value of de is added to hl.">add hl,de</td>
          <td axis="------|1|7|Loads the value pointed to by de into a.">ld a,(de)</td>
          <td axis="------|1|6|Subtracts one from de.">dec de</td>
          <td axis="-+V+++|1|4|Adds one to e.">inc e</td>
          <td axis="-+V+++|1|4|Subtracts one from e.">dec e</td>
          <td axis="------|2|7|Loads * into e.">ld e,*</td>
          <td axis="+0-0--|1|4|The contents of a are rotated right one bit position. The contents of bit 0 are copied to the carry flag and the previous contents of the carry flag are copied to bit 7.">rra</td>
        </tr>
        <tr>
          <th>2</th>
          <td axis="------|2|12/7|If condition cc is true, the signed value * is added to pc. The jump is measured from the start of the instruction opcode.">jr nz,*</td>
          <td axis="------|3|10|Loads ** into hl.">ld hl,**</td>
          <td axis="------|3|16|Stores hl into the memory location pointed to by **.">ld (**),hl</td>
          <td axis="------|1|6|Adds one to hl.">inc hl</td>
          <td axis="-+V+++|1|4|Adds one to h.">inc h</td>
          <td axis="-+V+++|1|4|Subtracts one from h.">dec h</td>
          <td axis="------|2|7|Loads * into h.">ld h,*</td>
          <td axis="*-P*++|1|4|Adjusts a for BCD addition and subtraction operations.">daa</td>
          <td axis="------|2|12/7|If condition cc is true, the signed value * is added to pc. The jump is measured from the start of the instruction opcode.">jr z,*</td>
          <td axis="++-+--|1|11|The value of hl is added to hl.">add hl,hl</td>
          <td axis="------|3|16|Loads the value pointed to by ** into hl.">ld hl,(**)</td>
          <td axis="------|1|6|Subtracts one from hl.">dec hl</td>
          <td axis="-+V+++|1|4|Adds one to l.">inc l</td>
          <td axis="-+V+++|1|4|Subtracts one from l.">dec l</td>
          <td axis="------|2|7|Loads * into l.">ld l,*</td>
          <td axis="-1-1--|1|4|The contents of a are inverted (one's complement).">cpl</td>
        </tr>
        <tr>
          <th>3</th>
          <td axis="------|2|12/7|If condition cc is true, the signed value * is added to pc. The jump is measured from the start of the instruction opcode.">jr nc,*</td>
          <td axis="------|3|10|Loads ** into sp.">ld sp,**</td>
          <td axis="------|3|13|Stores a into the memory location pointed to by **.">ld (**),a</td>
          <td axis="------|1|6|Adds one to sp.">inc sp</td>
          <td axis="-+V+++|1|11|Adds one to (hl).">inc (hl)</td>
          <td axis="-+V+++|1|11|Subtracts one from (hl).">dec (hl)</td>
          <td axis="------|2|10|Loads * into (hl).">ld (hl),*</td>
          <td axis="10-0--|1|4|Sets the carry flag.">scf</td>
          <td axis="------|2|12/7|If condition cc is true, the signed value * is added to pc. The jump is measured from the start of the instruction opcode.">jr c,*</td>
          <td axis="++-+--|1|11|The value of sp is added to hl.">add hl,sp</td>
          <td axis="------|3|13|Loads the value pointed to by ** into a.">ld a,(**)</td>
          <td axis="------|1|6|Subtracts one from sp.">dec sp</td>
          <td axis="-+V+++|1|4|Adds one to a.">inc a</td>
          <td axis="-+V+++|1|4|Subtracts one from a.">dec a</td>
          <td axis="------|2|7|Loads * into a.">ld a,*</td>
          <td axis="*0-*--|1|4|Inverts the carry flag.">ccf</td>
        </tr>
        <tr>
          <th>4</th>
          <td axis="------|1|4|The contents of b are loaded into b.">ld b,b</td>
          <td axis="------|1|4|The contents of c are loaded into b.">ld b,c</td>
          <td axis="------|1|4|The contents of d are loaded into b.">ld b,d</td>
          <td axis="------|1|4|The contents of e are loaded into b.">ld b,e</td>
          <td axis="------|1|4|The contents of h are loaded into b.">ld b,h</td>
          <td axis="------|1|4|The contents of l are loaded into b.">ld b,l</td>
          <td axis="------|1|7|The contents of (hl) are loaded into b.">ld b,(hl)</td>
          <td axis="------|1|4|The contents of a are loaded into b.">ld b,a</td>
          <td axis="------|1|4|The contents of b are loaded into c.">ld c,b</td>
          <td axis="------|1|4|The contents of c are loaded into c.">ld c,c</td>
          <td axis="------|1|4|The contents of d are loaded into c.">ld c,d</td>
          <td axis="------|1|4|The contents of e are loaded into c.">ld c,e</td>
          <td axis="------|1|4|The contents of h are loaded into c.">ld c,h</td>
          <td axis="------|1|4|The contents of l are loaded into c.">ld c,l</td>
          <td axis="------|1|7|The contents of (hl) are loaded into c.">ld c,(hl)</td>
          <td axis="------|1|4|The contents of a are loaded into c.">ld c,a</td>
        </tr>
        <tr>
          <th>5</th>
          <td axis="------|1|4|The contents of b are loaded into d.">ld d,b</td>
          <td axis="------|1|4|The contents of c are loaded into d.">ld d,c</td>
          <td axis="------|1|4|The contents of d are loaded into d.">ld d,d</td>
          <td axis="------|1|4|The contents of e are loaded into d.">ld d,e</td>
          <td axis="------|1|4|The contents of h are loaded into d.">ld d,h</td>
          <td axis="------|1|4|The contents of l are loaded into d.">ld d,l</td>
          <td axis="------|1|7|The contents of (hl) are loaded into d.">ld d,(hl)</td>
          <td axis="------|1|4|The contents of a are loaded into d.">ld d,a</td>
          <td axis="------|1|4|The contents of b are loaded into e.">ld e,b</td>
          <td axis="------|1|4|The contents of c are loaded into e.">ld e,c</td>
          <td axis="------|1|4|The contents of d are loaded into e.">ld e,d</td>
          <td axis="------|1|4|The contents of e are loaded into e.">ld e,e</td>
          <td axis="------|1|4|The contents of h are loaded into e.">ld e,h</td>
          <td axis="------|1|4|The contents of l are loaded into e.">ld e,l</td>
          <td axis="------|1|7|The contents of (hl) are loaded into e.">ld e,(hl)</td>
          <td axis="------|1|4|The contents of a are loaded into e.">ld e,a</td>
        </tr>
        <tr>
          <th>6</th>
          <td axis="------|1|4|The contents of b are loaded into h.">ld h,b</td>
          <td axis="------|1|4|The contents of c are loaded into h.">ld h,c</td>
          <td axis="------|1|4|The contents of d are loaded into h.">ld h,d</td>
          <td axis="------|1|4|The contents of e are loaded into h.">ld h,e</td>
          <td axis="------|1|4|The contents of h are loaded into h.">ld h,h</td>
          <td axis="------|1|4|The contents of l are loaded into h.">ld h,l</td>
          <td axis="------|1|7|The contents of (hl) are loaded into h.">ld h,(hl)</td>
          <td axis="------|1|4|The contents of a are loaded into h.">ld h,a</td>
          <td axis="------|1|4|The contents of b are loaded into l.">ld l,b</td>
          <td axis="------|1|4|The contents of c are loaded into l.">ld l,c</td>
          <td axis="------|1|4|The contents of d are loaded into l.">ld l,d</td>
          <td axis="------|1|4|The contents of e are loaded into l.">ld l,e</td>
          <td axis="------|1|4|The contents of h are loaded into l.">ld l,h</td>
          <td axis="------|1|4|The contents of l are loaded into l.">ld l,l</td>
          <td axis="------|1|7|The contents of (hl) are loaded into l.">ld l,(hl)</td>
          <td axis="------|1|4|The contents of a are loaded into l.">ld l,a</td>
        </tr>
        <tr>
          <th>7</th>
          <td axis="------|1|7|The contents of b are loaded into (hl).">ld (hl),b</td>
          <td axis="------|1|7|The contents of c are loaded into (hl).">ld (hl),c</td>
          <td axis="------|1|7|The contents of d are loaded into (hl).">ld (hl),d</td>
          <td axis="------|1|7|The contents of e are loaded into (hl).">ld (hl),e</td>
          <td axis="------|1|7|The contents of h are loaded into (hl).">ld (hl),h</td>
          <td axis="------|1|7|The contents of l are loaded into (hl).">ld (hl),l</td>
          <td axis="------|1|4|Suspends CPU operation until an interrupt or reset occurs.">halt</td>
          <td axis="------|1|7|The contents of a are loaded into (hl).">ld (hl),a</td>
          <td axis="------|1|4|The contents of b are loaded into a.">ld a,b</td>
          <td axis="------|1|4|The contents of c are loaded into a.">ld a,c</td>
          <td axis="------|1|4|The contents of d are loaded into a.">ld a,d</td>
          <td axis="------|1|4|The contents of e are loaded into a.">ld a,e</td>
          <td axis="------|1|4|The contents of h are loaded into a.">ld a,h</td>
          <td axis="------|1|4|The contents of l are loaded into a.">ld a,l</td>
          <td axis="------|1|7|The contents of (hl) are loaded into a.">ld a,(hl)</td>
          <td axis="------|1|4|The contents of a are loaded into a.">ld a,a</td>
        </tr>
        <tr>
          <th>8</th>
          <td axis="++V+++|1|4|Adds b to a.">add a,b</td>
          <td axis="++V+++|1|4|Adds c to a.">add a,c</td>
          <td axis="++V+++|1|4|Adds d to a.">add a,d</td>
          <td axis="++V+++|1|4|Adds e to a.">add a,e</td>
          <td axis="++V+++|1|4|Adds h to a.">add a,h</td>
          <td axis="++V+++|1|4|Adds l to a.">add a,l</td>
          <td axis="++V+++|1|7|Adds (hl) to a.">add a,(hl)</td>
          <td axis="++V+++|1|4|Adds a to a.">add a,a</td>
          <td axis="++V+++|1|4|Adds b and the carry flag to a.">adc a,b</td>
          <td axis="++V+++|1|4|Adds c and the carry flag to a.">adc a,c</td>
          <td axis="++V+++|1|4|Adds d and the carry flag to a.">adc a,d</td>
          <td axis="++V+++|1|4|Adds e and the carry flag to a.">adc a,e</td>
          <td axis="++V+++|1|4|Adds h and the carry flag to a.">adc a,h</td>
          <td axis="++V+++|1|4|Adds l and the carry flag to a.">adc a,l</td>
          <td axis="++V+++|1|7|Adds (hl) and the carry flag to a.">adc a,(hl)</td>
          <td axis="++V+++|1|4|Adds a and the carry flag to a.">adc a,a</td>
        </tr>
        <tr>
          <th>9</th>
          <td axis="++V+++|1|4|Subtracts b from a.">sub b</td>
          <td axis="++V+++|1|4|Subtracts c from a.">sub c</td>
          <td axis="++V+++|1|4|Subtracts d from a.">sub d</td>
          <td axis="++V+++|1|4|Subtracts e from a.">sub e</td>
          <td axis="++V+++|1|4|Subtracts h from a.">sub h</td>
          <td axis="++V+++|1|4|Subtracts l from a.">sub l</td>
          <td axis="++V+++|1|7|Subtracts (hl) from a.">sub (hl)</td>
          <td axis="++V+++|1|4|Subtracts a from a.">sub a</td>
          <td axis="++V+++|1|4|Subtracts b and the carry flag from a.">sbc a,b</td>
          <td axis="++V+++|1|4|Subtracts c and the carry flag from a.">sbc a,c</td>
          <td axis="++V+++|1|4|Subtracts d and the carry flag from a.">sbc a,d</td>
          <td axis="++V+++|1|4|Subtracts e and the carry flag from a.">sbc a,e</td>
          <td axis="++V+++|1|4|Subtracts h and the carry flag from a.">sbc a,h</td>
          <td axis="++V+++|1|4|Subtracts l and the carry flag from a.">sbc a,l</td>
          <td axis="++V+++|1|7|Subtracts (hl) and the carry flag from a.">sbc a,(hl)</td>
          <td axis="++V+++|1|4|Subtracts a and the carry flag from a.">sbc a,a</td>
        </tr>
        <tr>
          <th>A</th>
          <td axis="00P1++|1|4|Bitwise AND on a with b.">and b</td>
          <td axis="00P1++|1|4|Bitwise AND on a with c.">and c</td>
          <td axis="00P1++|1|4|Bitwise AND on a with d.">and d</td>
          <td axis="00P1++|1|4|Bitwise AND on a with e.">and e</td>
          <td axis="00P1++|1|4|Bitwise AND on a with h.">and h</td>
          <td axis="00P1++|1|4|Bitwise AND on a with l.">and l</td>
          <td axis="00P1++|1|7|Bitwise AND on a with (hl).">and (hl)</td>
          <td axis="00P1++|1|4|Bitwise AND on a with a.">and a</td>
          <td axis="00P0++|1|4|Bitwise XOR on a with b.">xor b</td>
          <td axis="00P0++|1|4|Bitwise XOR on a with c.">xor c</td>
          <td axis="00P0++|1|4|Bitwise XOR on a with d.">xor d</td>
          <td axis="00P0++|1|4|Bitwise XOR on a with e.">xor e</td>
          <td axis="00P0++|1|4|Bitwise XOR on a with h.">xor h</td>
          <td axis="00P0++|1|4|Bitwise XOR on a with l.">xor l</td>
          <td axis="00P0++|1|7|Bitwise XOR on a with (hl).">xor (hl)</td>
          <td axis="00P0++|1|4|Bitwise XOR on a with a.">xor a</td>
        </tr>
        <tr>
          <th>B</th>
          <td axis="00P0++|1|4|Bitwise OR on a with b.">or b</td>
          <td axis="00P0++|1|4|Bitwise OR on a with c.">or c</td>
          <td axis="00P0++|1|4|Bitwise OR on a with d.">or d</td>
          <td axis="00P0++|1|4|Bitwise OR on a with e.">or e</td>
          <td axis="00P0++|1|4|Bitwise OR on a with h.">or h</td>
          <td axis="00P0++|1|4|Bitwise OR on a with l.">or l</td>
          <td axis="00P0++|1|7|Bitwise OR on a with (hl).">or (hl)</td>
          <td axis="00P0++|1|4|Bitwise OR on a with a.">or a</td>
          <td axis="++V+++|1|4|Subtracts b from a and affects flags according to the result. a is not modified.">cp b</td>
          <td axis="++V+++|1|4|Subtracts c from a and affects flags according to the result. a is not modified.">cp c</td>
          <td axis="++V+++|1|4|Subtracts d from a and affects flags according to the result. a is not modified.">cp d</td>
          <td axis="++V+++|1|4|Subtracts e from a and affects flags according to the result. a is not modified.">cp e</td>
          <td axis="++V+++|1|4|Subtracts h from a and affects flags according to the result. a is not modified.">cp h</td>
          <td axis="++V+++|1|4|Subtracts l from a and affects flags according to the result. a is not modified.">cp l</td>
          <td axis="++V+++|1|7|Subtracts (hl) from a and affects flags according to the result. a is not modified.">cp (hl)</td>
          <td axis="++V+++|1|4|Subtracts a from a and affects flags according to the result. a is not modified.">cp a</td>
        </tr>
        <tr>
          <th>C</th>
          <td axis="------|1|11/5|If condition cc is true, the top stack entry is popped into pc.">ret nz</td>
          <td axis="------|1|10|The memory location pointed to by sp is stored into c and sp is incremented. The memory location pointed to by sp is stored into b and sp is incremented again.">pop bc</td>
          <td axis="------|3|10|If condition cc is true, ** is copied to pc.">jp nz,**</td>
          <td axis="------|3|10|** is copied to pc.">jp **</td>
          <td axis="------|3|17/10|If condition cc is true, the current pc value plus three is pushed onto the stack, then is loaded with **.">call nz,**</td>
          <td axis="------|1|11|sp is decremented and b is stored into the memory location pointed to by sp. sp is decremented again and c is stored into the memory location pointed to by sp.">push bc</td>
          <td axis="++V+++|2|7|Adds * to a.">add a,*</td>
          <td axis="------|1|11|The current pc value plus one is pushed onto the stack, then is loaded with 00h.">rst 00h</td>
          <td axis="------|1|11/5|If condition cc is true, the top stack entry is popped into pc.">ret z</td>
          <td axis="------|1|10|The top stack entry is popped into pc.">ret</td>
          <td axis="------|3|10|If condition cc is true, ** is copied to pc.">jp z,**</td>
          <td class="ln">
            <a href="#table3">BITS</a>
          </td>
          <td axis="------|3|17/10|If condition cc is true, the current pc value plus three is pushed onto the stack, then is loaded with **.">call z,**</td>
          <td axis="------|3|17|The current pc value plus three is pushed onto the stack, then is loaded with **.">call **</td>
          <td axis="++V+++|2|7|Adds * and the carry flag to a.">adc a,*</td>
          <td axis="------|1|11|The current pc value plus one is pushed onto the stack, then is loaded with 08h.">rst 08h</td>
        </tr>
        <tr>
          <th>D</th>
          <td axis="------|1|11/5|If condition cc is true, the top stack entry is popped into pc.">ret nc</td>
          <td axis="------|1|10|The memory location pointed to by sp is stored into e and sp is incremented. The memory location pointed to by sp is stored into d and sp is incremented again.">pop de</td>
          <td axis="------|3|10|If condition cc is true, ** is copied to pc.">jp nc,**</td>
          <td axis="------|2|11|The value of a is written to port *.">out (*),a</td>
          <td axis="------|3|17/10|If condition cc is true, the current pc value plus three is pushed onto the stack, then is loaded with **.">call nc,**</td>
          <td axis="------|1|11|sp is decremented and d is stored into the memory location pointed to by sp. sp is decremented again and e is stored into the memory location pointed to by sp.">push de</td>
          <td axis="++V+++|2|7|Subtracts * from a.">sub *</td>
          <td axis="------|1|11|The current pc value plus one is pushed onto the stack, then is loaded with 10h.">rst 10h</td>
          <td axis="------|1|11/5|If condition cc is true, the top stack entry is popped into pc.">ret c</td>
          <td axis="------|1|4|Exchanges the 16-bit contents of bc, de, and hl with bc', de', and hl'.">exx</td>
          <td axis="------|3|10|If condition cc is true, ** is copied to pc.">jp c,**</td>
          <td axis="------|2|11|A byte from port * is written to a.">in a,(*)</td>
          <td axis="------|3|17/10|If condition cc is true, the current pc value plus three is pushed onto the stack, then is loaded with **.">call c,**</td>
          <td class="ln">
            <a href="#table4">IX</a>
          </td>
          <td axis="++V+++|2|7|Subtracts * and the carry flag from a.">sbc a,*</td>
          <td axis="------|1|11|The current pc value plus one is pushed onto the stack, then is loaded with 18h.">rst 18h</td>
        </tr>
        <tr>
          <th>E</th>
          <td axis="------|1|11/5|If condition cc is true, the top stack entry is popped into pc.">ret po</td>
          <td axis="------|1|10|The memory location pointed to by sp is stored into l and sp is incremented. The memory location pointed to by sp is stored into h and sp is incremented again.">pop hl</td>
          <td axis="------|3|10|If condition cc is true, ** is copied to pc.">jp po,**</td>
          <td axis="------|1|19|Exchanges (sp) with l, and (sp+1) with h.">ex (sp),hl</td>
          <td axis="------|3|17/10|If condition cc is true, the current pc value plus three is pushed onto the stack, then is loaded with **.">call po,**</td>
          <td axis="------|1|11|sp is decremented and h is stored into the memory location pointed to by sp. sp is decremented again and l is stored into the memory location pointed to by sp.">push hl</td>
          <td axis="00P1++|2|7|Bitwise AND on a with *.">and *</td>
          <td axis="------|1|11|The current pc value plus one is pushed onto the stack, then is loaded with 20h.">rst 20h</td>
          <td axis="------|1|11/5|If condition cc is true, the top stack entry is popped into pc.">ret pe</td>
          <td axis="------|1|4|Loads the value of hl into pc.">jp (hl)</td>
          <td axis="------|3|10|If condition cc is true, ** is copied to pc.">jp pe,**</td>
          <td axis="------|1|4|Exchanges the 16-bit contents of de and hl.">ex de,hl</td>
          <td axis="------|3|17/10|If condition cc is true, the current pc value plus three is pushed onto the stack, then is loaded with **.">call pe,**</td>
          <td class="ln">
            <a href="#table2">EXTD</a>
          </td>
          <td axis="00P0++|2|7|Bitwise XOR on a with *.">xor *</td>
          <td axis="------|1|11|The current pc value plus one is pushed onto the stack, then is loaded with 28h.">rst 28h</td>
        </tr>
        <tr>
          <th>F</th>
          <td axis="------|1|11/5|If condition cc is true, the top stack entry is popped into pc.">ret p</td>
          <td axis="------|1|10|The memory location pointed to by sp is stored into f and sp is incremented. The memory location pointed to by sp is stored into a and sp is incremented again.">pop af</td>
          <td axis="------|3|10|If condition cc is true, ** is copied to pc.">jp p,**</td>
          <td axis="------|1|4|Resets both interrupt flip-flops, thus prenting maskable interrupts from triggering.">di</td>
          <td axis="------|3|17/10|If condition cc is true, the current pc value plus three is pushed onto the stack, then is loaded with **.">call p,**</td>
          <td axis="------|1|11|sp is decremented and a is stored into the memory location pointed to by sp. sp is decremented again and f is stored into the memory location pointed to by sp.">push af</td>
          <td axis="00P0++|2|7|Bitwise OR on a with *.">or *</td>
          <td axis="------|1|11|The current pc value plus one is pushed onto the stack, then is loaded with 30h.">rst 30h</td>
          <td axis="------|1|11/5|If condition cc is true, the top stack entry is popped into pc.">ret m</td>
          <td axis="------|1|6|Loads the value of hl into sp.">ld sp,hl</td>
          <td axis="------|3|10|If condition cc is true, ** is copied to pc.">jp m,**</td>
          <td axis="------|1|4|Sets both interrupt flip-flops, thus allowing maskable interrupts to occur. An interrupt will not occur until after the immediatedly following instruction.">ei</td>
          <td axis="------|3|17/10|If condition cc is true, the current pc value plus three is pushed onto the stack, then is loaded with **.">call m,**</td>
          <td class="ln">
            <a href="#table6">IY</a>
          </td>
          <td axis="++V+++|2|7|Subtracts * from a and affects flags according to the result. a is not modified.">cp *</td>
          <td axis="------|1|11|The current pc value plus one is pushed onto the stack, then is loaded with 38h.">rst 38h</td>
        </tr>
      </table>
      <h3 id="table2">Extended instructions (ED)</h3>
      <table title="ED">
        <tr>
          <td></td>
          <th>0</th>
          <th>1</th>
          <th>2</th>
          <th>3</th>
          <th>4</th>
          <th>5</th>
          <th>6</th>
          <th>7</th>
          <th>8</th>
          <th>9</th>
          <th>A</th>
          <th>B</th>
          <th>C</th>
          <th>D</th>
          <th>E</th>
          <th>F</th>
        </tr>
        <tr style="display: none;">
          <td></td>
        </tr>
        <tr style="display: none;">
          <td></td>
        </tr>
        <tr style="display: none;">
          <td></td>
        </tr>
        <tr style="display: none;">
          <td></td>
        </tr>
        <tr>
          <th>4</th>
          <td axis="-0P0++|2|12|A byte from port c is written to b.">in b,(c)</td>
          <td axis="------|2|12|The value of b is written to port c.">out (c),b</td>
          <td axis="++V+++|2|15|Subtracts bc and the carry flag from hl.">sbc hl,bc</td>
          <td axis="------|4|20|Stores bc into the memory location pointed to by **.">ld (**),bc</td>
          <td axis="++V+++|2|8|The contents of a are negated (two's complement). Operation is the same as subtracting a from zero.">neg</td>
          <td axis="------|2|14|Used at the end of a non-maskable interrupt service routine (located at $0066) to pop the top stack entry into PC. The value of IFF2 is copied to IFF1 so that maskable interrupts are allowed to continue as before. NMIs are not enabled on the TI.">retn</td>
          <td axis="------|2|8|Sets interrupt mode 0.">im 0</td>
          <td axis="------|2|9|Stores the value of a into register i or r.">ld i,a</td>
          <td axis="-0P0++|2|12|A byte from port c is written to c.">in c,(c)</td>
          <td axis="------|2|12|The value of c is written to port c.">out (c),c</td>
          <td axis="++V+++|2|15|Adds bc and the carry flag to hl.">adc hl,bc</td>
          <td axis="------|4|20|Loads the value pointed to by ** into bc.">ld bc,(**)</td>
          <td class="un" axis="++V+++|2|8|The contents of a are negated (two's complement). Operation is the same as subtracting a from zero.">neg</td>
          <td axis="------|2|14|Used at the end of a maskable interrupt service routine. The top stack entry is popped into pc, and signals an I/O device that the interrupt has finished, allowing nested interrupts (not a consideration on the TI).">reti</td>
          <td class="un" axis="------|2|8|Sets undefined interrupt mode 0/1.">im 0/1</td>
          <td axis="------|2|9|Stores the value of a into register i or r.">ld r,a</td>
        </tr>
        <tr>
          <th>5</th>
          <td axis="-0P0++|2|12|A byte from port c is written to d.">in d,(c)</td>
          <td axis="------|2|12|The value of d is written to port c.">out (c),d</td>
          <td axis="++V+++|2|15|Subtracts de and the carry flag from hl.">sbc hl,de</td>
          <td axis="------|4|20|Stores de into the memory location pointed to by **.">ld (**),de</td>
          <td class="un" axis="++V+++|2|8|The contents of a are negated (two's complement). Operation is the same as subtracting a from zero.">neg</td>
          <td axis="------|2|14|Used at the end of a non-maskable interrupt service routine (located at $0066) to pop the top stack entry into PC. The value of IFF2 is copied to IFF1 so that maskable interrupts are allowed to continue as before. NMIs are not enabled on the TI.">retn</td>
          <td axis="------|2|8|Sets interrupt mode 1.">im 1</td>
          <td axis="-0*0++|2|9|Stores the value of register i or r into a.">ld a,i</td>
          <td axis="-0P0++|2|12|A byte from port c is written to e.">in e,(c)</td>
          <td axis="------|2|12|The value of e is written to port c.">out (c),e</td>
          <td axis="++V+++|2|15|Adds de and the carry flag to hl.">adc hl,de</td>
          <td axis="------|4|20|Loads the value pointed to by ** into de.">ld de,(**)</td>
          <td class="un" axis="++V+++|2|8|The contents of a are negated (two's complement). Operation is the same as subtracting a from zero.">neg</td>
          <td axis="------|2|14|Used at the end of a non-maskable interrupt service routine (located at $0066) to pop the top stack entry into PC. The value of IFF2 is copied to IFF1 so that maskable interrupts are allowed to continue as before. NMIs are not enabled on the TI.">retn</td>
          <td axis="------|2|8|Sets interrupt mode 2.">im 2</td>
          <td axis="-0*0++|2|9|Stores the value of register i or r into a.">ld a,r</td>
        </tr>
        <tr>
          <th>6</th>
          <td axis="-0P0++|2|12|A byte from port c is written to h.">in h,(c)</td>
          <td axis="------|2|12|The value of h is written to port c.">out (c),h</td>
          <td axis="++V+++|2|15|Subtracts hl and the carry flag from hl.">sbc hl,hl</td>
          <td class="un" axis="------|4|20|Stores hl into the memory location pointed to by **.">ld (**),hl</td>
          <td class="un" axis="++V+++|2|8|The contents of a are negated (two's complement). Operation is the same as subtracting a from zero.">neg</td>
          <td axis="------|2|14|Used at the end of a non-maskable interrupt service routine (located at $0066) to pop the top stack entry into PC. The value of IFF2 is copied to IFF1 so that maskable interrupts are allowed to continue as before. NMIs are not enabled on the TI.">retn</td>
          <td axis="------|2|8|Sets interrupt mode 0.">im 0</td>
          <td axis="-0P0++|2|18|The contents of the low-order nibble of (hl) are copied to the low-order nibble of a. The previous contents are copied to the high-order nibble of (hl). The previous contents are copied to the low-order nibble of (hl).">rrd</td>
          <td axis="-0P0++|2|12|A byte from port c is written to l.">in l,(c)</td>
          <td axis="------|2|12|The value of l is written to port c.">out (c),l</td>
          <td axis="++V+++|2|15|Adds hl and the carry flag to hl.">adc hl,hl</td>
          <td class="un" axis="------|4|20|Loads the value pointed to by ** into hl.">ld hl,(**)</td>
          <td class="un" axis="++V+++|2|8|The contents of a are negated (two's complement). Operation is the same as subtracting a from zero.">neg</td>
          <td axis="------|2|14|Used at the end of a non-maskable interrupt service routine (located at $0066) to pop the top stack entry into PC. The value of IFF2 is copied to IFF1 so that maskable interrupts are allowed to continue as before. NMIs are not enabled on the TI.">retn</td>
          <td class="un" axis="------|2|8|Sets undefined interrupt mode 0/1.">im 0/1</td>
          <td axis="-0P0++|2|18|The contents of the low-order nibble of (hl) are copied to the high-order nibble of (hl). The previous contents are copied to the low-order nibble of a. The previous contents are copied to the low-order nibble of (hl).">rld</td>
        </tr>
        <tr>
          <th>7</th>
          <td class="un" axis="-0P0++|2|12|Inputs a byte from port c and affects flags only.">in (c)</td>
          <td class="un" axis="------|2|12|Outputs a zero to port c.">out (c),0</td>
          <td axis="++V+++|2|15|Subtracts sp and the carry flag from hl.">sbc hl,sp</td>
          <td axis="------|4|20|Stores sp into the memory location pointed to by **.">ld (**),sp</td>
          <td class="un" axis="++V+++|2|8|The contents of a are negated (two's complement). Operation is the same as subtracting a from zero.">neg</td>
          <td axis="------|2|14|Used at the end of a non-maskable interrupt service routine (located at $0066) to pop the top stack entry into PC. The value of IFF2 is copied to IFF1 so that maskable interrupts are allowed to continue as before. NMIs are not enabled on the TI.">retn</td>
          <td axis="------|2|8|Sets interrupt mode 1.">im 1</td>
          <td></td>
          <td axis="-0P0++|2|12|A byte from port c is written to a.">in a,(c)</td>
          <td axis="------|2|12|The value of a is written to port c.">out (c),a</td>
          <td axis="++V+++|2|15|Adds sp and the carry flag to hl.">adc hl,sp</td>
          <td axis="------|4|20|Loads the value pointed to by ** into sp.">ld sp,(**)</td>
          <td class="un" axis="++V+++|2|8|The contents of a are negated (two's complement). Operation is the same as subtracting a from zero.">neg</td>
          <td axis="------|2|14|Used at the end of a non-maskable interrupt service routine (located at $0066) to pop the top stack entry into PC. The value of IFF2 is copied to IFF1 so that maskable interrupts are allowed to continue as before. NMIs are not enabled on the TI.">retn</td>
          <td axis="------|2|8|Sets interrupt mode 2.">im 2</td>
          <td></td>
        </tr>
        <tr style="display: none;">
          <td></td>
        </tr>
        <tr style="display: none;">
          <td></td>
        </tr>
        <tr>
          <th>A</th>
          <td axis="-0*0--|2|16|Transfers a byte of data from the memory location pointed to by hl to the memory location pointed to by de. Then hl and de are incremented and bc is decremented.">ldi</td>
          <td axis="-1*+++|2|16|Compares the value of the memory location pointed to by hl with a. Then hl is incremented and bc is decremented.">cpi</td>
          <td axis="-1  * |2|16|A byte from port c is written to the memory location pointed to by hl. Then hl is incremented and b is decremented.">ini</td>
          <td axis="-1  * |2|16|A byte from the memory location pointed to by hl is written to port c. Then hl is incremented and b is decremented.">outi</td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td axis="-0*0--|2|16|Transfers a byte of data from the memory location pointed to by hl to the memory location pointed to by de. Then hl, de, and bc are decremented.">ldd</td>
          <td axis="-1*+++|2|16|Compares the value of the memory location pointed to by hl with a. Then hl and bc are decremented.">cpd</td>
          <td axis="-1  * |2|16|A byte from port c is written to the memory location pointed to by hl. Then hl and b are decremented.">ind</td>
          <td axis="-1  * |2|16|A byte from the memory location pointed to by hl is written to port c. Then hl and b are decremented.">outd</td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <th>B</th>
          <td axis="-000--|2|21/16|Transfers a byte of data from the memory location pointed to by hl to the memory location pointed to by de. Then hl and de are incremented and bc is decremented. If bc is not zero, this operation is repeated. Interrupts can trigger while this instruction is processing.">ldir</td>
          <td axis="-10+++|2|21/16|Compares the value of the memory location pointed to by hl with a. Then hl is incremented and bc is decremented. If bc is not zero and z is not set, this operation is repeated. Interrupts can trigger while this instruction is processing.">cpir</td>
          <td axis="-1  1 |2|21/16|A byte from port c is written to the memory location pointed to by hl. Then hl is incremented and b is decremented. If b is not zero, this operation is repeated. Interrupts can trigger while this instruction is processing.">inir</td>
          <td axis="-1  1 |2|21/16|A byte from the memory location pointed to by hl is written to port c. Then hl is incremented and b is decremented. If b is not zero, this operation is repeated. Interrupts can trigger while this instruction is processing.">otir</td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td axis="-000--|2|21/16|Transfers a byte of data from the memory location pointed to by hl to the memory location pointed to by de. Then hl, de, and bc are decremented. If bc is not zero, this operation is repeated. Interrupts can trigger while this instruction is processing.">lddr</td>
          <td axis="-10+++|2|21/16|Compares the value of the memory location pointed to by hl with a. Then hl and bc are decremented. If bc is not zero and z is not set, this operation is repeated. Interrupts can trigger while this instruction is processing.">cpdr</td>
          <td axis="-1  1 |2|21/16|A byte from port c is written to the memory location pointed to by hl. Then hl and b are decremented. If b is not zero, this operation is repeated. Interrupts can trigger while this instruction is processing.">indr</td>
          <td axis="-1  1 |2|21/16|A byte from the memory location pointed to by hl is written to port c. Then hl and b are decremented. If b is not zero, this operation is repeated. Interrupts can trigger while this instruction is processing.">otdr</td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
      </table>
      <h3 id="table3">Bit instructions (CB)</h3>
      <table title="CB">
        <tr>
          <td></td>
          <th>0</th>
          <th>1</th>
          <th>2</th>
          <th>3</th>
          <th>4</th>
          <th>5</th>
          <th>6</th>
          <th>7</th>
          <th>8</th>
          <th>9</th>
          <th>A</th>
          <th>B</th>
          <th>C</th>
          <th>D</th>
          <th>E</th>
          <th>F</th>
        </tr>
        <tr>
          <th>0</th>
          <td axis="+0P0++|2|8|The contents of b are rotated left one bit position. The contents of bit 7 are copied to the carry flag and bit 0.">rlc b</td>
          <td axis="+0P0++|2|8|The contents of c are rotated left one bit position. The contents of bit 7 are copied to the carry flag and bit 0.">rlc c</td>
          <td axis="+0P0++|2|8|The contents of d are rotated left one bit position. The contents of bit 7 are copied to the carry flag and bit 0.">rlc d</td>
          <td axis="+0P0++|2|8|The contents of e are rotated left one bit position. The contents of bit 7 are copied to the carry flag and bit 0.">rlc e</td>
          <td axis="+0P0++|2|8|The contents of h are rotated left one bit position. The contents of bit 7 are copied to the carry flag and bit 0.">rlc h</td>
          <td axis="+0P0++|2|8|The contents of l are rotated left one bit position. The contents of bit 7 are copied to the carry flag and bit 0.">rlc l</td>
          <td axis="+0P0++|2|15|The contents of (hl) are rotated left one bit position. The contents of bit 7 are copied to the carry flag and bit 0.">rlc (hl)</td>
          <td axis="+0P0++|2|8|The contents of a are rotated left one bit position. The contents of bit 7 are copied to the carry flag and bit 0.">rlc a</td>
          <td axis="+0P0++|2|8|The contents of b are rotated right one bit position. The contents of bit 0 are copied to the carry flag and bit 7.">rrc b</td>
          <td axis="+0P0++|2|8|The contents of c are rotated right one bit position. The contents of bit 0 are copied to the carry flag and bit 7.">rrc c</td>
          <td axis="+0P0++|2|8|The contents of d are rotated right one bit position. The contents of bit 0 are copied to the carry flag and bit 7.">rrc d</td>
          <td axis="+0P0++|2|8|The contents of e are rotated right one bit position. The contents of bit 0 are copied to the carry flag and bit 7.">rrc e</td>
          <td axis="+0P0++|2|8|The contents of h are rotated right one bit position. The contents of bit 0 are copied to the carry flag and bit 7.">rrc h</td>
          <td axis="+0P0++|2|8|The contents of l are rotated right one bit position. The contents of bit 0 are copied to the carry flag and bit 7.">rrc l</td>
          <td axis="+0P0++|2|15|The contents of (hl) are rotated right one bit position. The contents of bit 0 are copied to the carry flag and bit 7.">rrc (hl)</td>
          <td axis="+0P0++|2|8|The contents of a are rotated right one bit position. The contents of bit 0 are copied to the carry flag and bit 7.">rrc a</td>
        </tr>
        <tr>
          <th>1</th>
          <td axis="+0P0++|2|8|The contents of b are rotated left one bit position. The contents of bit 7 are copied to the carry flag and the previous contents of the carry flag are copied to bit 0.">rl b</td>
          <td axis="+0P0++|2|8|The contents of c are rotated left one bit position. The contents of bit 7 are copied to the carry flag and the previous contents of the carry flag are copied to bit 0.">rl c</td>
          <td axis="+0P0++|2|8|The contents of d are rotated left one bit position. The contents of bit 7 are copied to the carry flag and the previous contents of the carry flag are copied to bit 0.">rl d</td>
          <td axis="+0P0++|2|8|The contents of e are rotated left one bit position. The contents of bit 7 are copied to the carry flag and the previous contents of the carry flag are copied to bit 0.">rl e</td>
          <td axis="+0P0++|2|8|The contents of h are rotated left one bit position. The contents of bit 7 are copied to the carry flag and the previous contents of the carry flag are copied to bit 0.">rl h</td>
          <td axis="+0P0++|2|8|The contents of l are rotated left one bit position. The contents of bit 7 are copied to the carry flag and the previous contents of the carry flag are copied to bit 0.">rl l</td>
          <td axis="+0P0++|2|15|The contents of (hl) are rotated left one bit position. The contents of bit 7 are copied to the carry flag and the previous contents of the carry flag are copied to bit 0.">rl (hl)</td>
          <td axis="+0P0++|2|8|The contents of a are rotated left one bit position. The contents of bit 7 are copied to the carry flag and the previous contents of the carry flag are copied to bit 0.">rl a</td>
          <td axis="+0P0++|2|8|The contents of b are rotated right one bit position. The contents of bit 0 are copied to the carry flag and the previous contents of the carry flag are copied to bit 7.">rr b</td>
          <td axis="+0P0++|2|8|The contents of c are rotated right one bit position. The contents of bit 0 are copied to the carry flag and the previous contents of the carry flag are copied to bit 7.">rr c</td>
          <td axis="+0P0++|2|8|The contents of d are rotated right one bit position. The contents of bit 0 are copied to the carry flag and the previous contents of the carry flag are copied to bit 7.">rr d</td>
          <td axis="+0P0++|2|8|The contents of e are rotated right one bit position. The contents of bit 0 are copied to the carry flag and the previous contents of the carry flag are copied to bit 7.">rr e</td>
          <td axis="+0P0++|2|8|The contents of h are rotated right one bit position. The contents of bit 0 are copied to the carry flag and the previous contents of the carry flag are copied to bit 7.">rr h</td>
          <td axis="+0P0++|2|8|The contents of l are rotated right one bit position. The contents of bit 0 are copied to the carry flag and the previous contents of the carry flag are copied to bit 7.">rr l</td>
          <td axis="+0P0++|2|15|The contents of (hl) are rotated right one bit position. The contents of bit 0 are copied to the carry flag and the previous contents of the carry flag are copied to bit 7.">rr (hl)</td>
          <td axis="+0P0++|2|8|The contents of a are rotated right one bit position. The contents of bit 0 are copied to the carry flag and the previous contents of the carry flag are copied to bit 7.">rr a</td>
        </tr>
        <tr>
          <th>2</th>
          <td axis="+0P0++|2|8|The contents of b are shifted left one bit position. The contents of bit 7 are copied to the carry flag and a zero is put into bit 0.">sla b</td>
          <td axis="+0P0++|2|8|The contents of c are shifted left one bit position. The contents of bit 7 are copied to the carry flag and a zero is put into bit 0.">sla c</td>
          <td axis="+0P0++|2|8|The contents of d are shifted left one bit position. The contents of bit 7 are copied to the carry flag and a zero is put into bit 0.">sla d</td>
          <td axis="+0P0++|2|8|The contents of e are shifted left one bit position. The contents of bit 7 are copied to the carry flag and a zero is put into bit 0.">sla e</td>
          <td axis="+0P0++|2|8|The contents of h are shifted left one bit position. The contents of bit 7 are copied to the carry flag and a zero is put into bit 0.">sla h</td>
          <td axis="+0P0++|2|8|The contents of l are shifted left one bit position. The contents of bit 7 are copied to the carry flag and a zero is put into bit 0.">sla l</td>
          <td axis="+0P0++|2|15|The contents of (hl) are shifted left one bit position. The contents of bit 7 are copied to the carry flag and a zero is put into bit 0.">sla (hl)</td>
          <td axis="+0P0++|2|8|The contents of a are shifted left one bit position. The contents of bit 7 are copied to the carry flag and a zero is put into bit 0.">sla a</td>
          <td axis="+0P0++|2|8|The contents of b are shifted right one bit position. The contents of bit 0 are copied to the carry flag and the previous contents of bit 7 are unchanged.">sra b</td>
          <td axis="+0P0++|2|8|The contents of c are shifted right one bit position. The contents of bit 0 are copied to the carry flag and the previous contents of bit 7 are unchanged.">sra c</td>
          <td axis="+0P0++|2|8|The contents of d are shifted right one bit position. The contents of bit 0 are copied to the carry flag and the previous contents of bit 7 are unchanged.">sra d</td>
          <td axis="+0P0++|2|8|The contents of e are shifted right one bit position. The contents of bit 0 are copied to the carry flag and the previous contents of bit 7 are unchanged.">sra e</td>
          <td axis="+0P0++|2|8|The contents of h are shifted right one bit position. The contents of bit 0 are copied to the carry flag and the previous contents of bit 7 are unchanged.">sra h</td>
          <td axis="+0P0++|2|8|The contents of l are shifted right one bit position. The contents of bit 0 are copied to the carry flag and the previous contents of bit 7 are unchanged.">sra l</td>
          <td axis="+0P0++|2|15|The contents of (hl) are shifted right one bit position. The contents of bit 0 are copied to the carry flag and the previous contents of bit 7 are unchanged.">sra (hl)</td>
          <td axis="+0P0++|2|8|The contents of a are shifted right one bit position. The contents of bit 0 are copied to the carry flag and the previous contents of bit 7 are unchanged.">sra a</td>
        </tr>
        <tr>
          <th>3</th>
          <td class="un" axis="+0P0++|2|8|The contents of b are shifted left one bit position. The contents of bit 7 are put into the carry flag and a one is put into bit 0.">sll b</td>
          <td class="un" axis="+0P0++|2|8|The contents of c are shifted left one bit position. The contents of bit 7 are put into the carry flag and a one is put into bit 0.">sll c</td>
          <td class="un" axis="+0P0++|2|8|The contents of d are shifted left one bit position. The contents of bit 7 are put into the carry flag and a one is put into bit 0.">sll d</td>
          <td class="un" axis="+0P0++|2|8|The contents of e are shifted left one bit position. The contents of bit 7 are put into the carry flag and a one is put into bit 0.">sll e</td>
          <td class="un" axis="+0P0++|2|8|The contents of h are shifted left one bit position. The contents of bit 7 are put into the carry flag and a one is put into bit 0.">sll h</td>
          <td class="un" axis="+0P0++|2|8|The contents of l are shifted left one bit position. The contents of bit 7 are put into the carry flag and a one is put into bit 0.">sll l</td>
          <td class="un" axis="+0P0++|2|15|The contents of (hl) are shifted left one bit position. The contents of bit 7 are put into the carry flag and a one is put into bit 0.">sll (hl)</td>
          <td class="un" axis="+0P0++|2|8|The contents of a are shifted left one bit position. The contents of bit 7 are put into the carry flag and a one is put into bit 0.">sll a</td>
          <td axis="+0P0++|2|8|The contents of b are shifted right one bit position. The contents of bit 0 are copied to the carry flag and a zero is put into bit 7.">srl b</td>
          <td axis="+0P0++|2|8|The contents of c are shifted right one bit position. The contents of bit 0 are copied to the carry flag and a zero is put into bit 7.">srl c</td>
          <td axis="+0P0++|2|8|The contents of d are shifted right one bit position. The contents of bit 0 are copied to the carry flag and a zero is put into bit 7.">srl d</td>
          <td axis="+0P0++|2|8|The contents of e are shifted right one bit position. The contents of bit 0 are copied to the carry flag and a zero is put into bit 7.">srl e</td>
          <td axis="+0P0++|2|8|The contents of h are shifted right one bit position. The contents of bit 0 are copied to the carry flag and a zero is put into bit 7.">srl h</td>
          <td axis="+0P0++|2|8|The contents of l are shifted right one bit position. The contents of bit 0 are copied to the carry flag and a zero is put into bit 7.">srl l</td>
          <td axis="+0P0++|2|15|The contents of (hl) are shifted right one bit position. The contents of bit 0 are copied to the carry flag and a zero is put into bit 7.">srl (hl)</td>
          <td axis="+0P0++|2|8|The contents of a are shifted right one bit position. The contents of bit 0 are copied to the carry flag and a zero is put into bit 7.">srl a</td>
        </tr>
        <tr>
          <th>4</th>
          <td axis="-0 1+ |2|8|Tests bit 0 of b.">bit 0,b</td>
          <td axis="-0 1+ |2|8|Tests bit 0 of c.">bit 0,c</td>
          <td axis="-0 1+ |2|8|Tests bit 0 of d.">bit 0,d</td>
          <td axis="-0 1+ |2|8|Tests bit 0 of e.">bit 0,e</td>
          <td axis="-0 1+ |2|8|Tests bit 0 of h.">bit 0,h</td>
          <td axis="-0 1+ |2|8|Tests bit 0 of l.">bit 0,l</td>
          <td axis="-0 1+ |2|12|Tests bit 0 of (hl).">bit 0,(hl)</td>
          <td axis="-0 1+ |2|8|Tests bit 0 of a.">bit 0,a</td>
          <td axis="-0 1+ |2|8|Tests bit 1 of b.">bit 1,b</td>
          <td axis="-0 1+ |2|8|Tests bit 1 of c.">bit 1,c</td>
          <td axis="-0 1+ |2|8|Tests bit 1 of d.">bit 1,d</td>
          <td axis="-0 1+ |2|8|Tests bit 1 of e.">bit 1,e</td>
          <td axis="-0 1+ |2|8|Tests bit 1 of h.">bit 1,h</td>
          <td axis="-0 1+ |2|8|Tests bit 1 of l.">bit 1,l</td>
          <td axis="-0 1+ |2|12|Tests bit 1 of (hl).">bit 1,(hl)</td>
          <td axis="-0 1+ |2|8|Tests bit 1 of a.">bit 1,a</td>
        </tr>
        <tr>
          <th>5</th>
          <td axis="-0 1+ |2|8|Tests bit 2 of b.">bit 2,b</td>
          <td axis="-0 1+ |2|8|Tests bit 2 of c.">bit 2,c</td>
          <td axis="-0 1+ |2|8|Tests bit 2 of d.">bit 2,d</td>
          <td axis="-0 1+ |2|8|Tests bit 2 of e.">bit 2,e</td>
          <td axis="-0 1+ |2|8|Tests bit 2 of h.">bit 2,h</td>
          <td axis="-0 1+ |2|8|Tests bit 2 of l.">bit 2,l</td>
          <td axis="-0 1+ |2|12|Tests bit 2 of (hl).">bit 2,(hl)</td>
          <td axis="-0 1+ |2|8|Tests bit 2 of a.">bit 2,a</td>
          <td axis="-0 1+ |2|8|Tests bit 3 of b.">bit 3,b</td>
          <td axis="-0 1+ |2|8|Tests bit 3 of c.">bit 3,c</td>
          <td axis="-0 1+ |2|8|Tests bit 3 of d.">bit 3,d</td>
          <td axis="-0 1+ |2|8|Tests bit 3 of e.">bit 3,e</td>
          <td axis="-0 1+ |2|8|Tests bit 3 of h.">bit 3,h</td>
          <td axis="-0 1+ |2|8|Tests bit 3 of l.">bit 3,l</td>
          <td axis="-0 1+ |2|12|Tests bit 3 of (hl).">bit 3,(hl)</td>
          <td axis="-0 1+ |2|8|Tests bit 3 of a.">bit 3,a</td>
        </tr>
        <tr>
          <th>6</th>
          <td axis="-0 1+ |2|8|Tests bit 4 of b.">bit 4,b</td>
          <td axis="-0 1+ |2|8|Tests bit 4 of c.">bit 4,c</td>
          <td axis="-0 1+ |2|8|Tests bit 4 of d.">bit 4,d</td>
          <td axis="-0 1+ |2|8|Tests bit 4 of e.">bit 4,e</td>
          <td axis="-0 1+ |2|8|Tests bit 4 of h.">bit 4,h</td>
          <td axis="-0 1+ |2|8|Tests bit 4 of l.">bit 4,l</td>
          <td axis="-0 1+ |2|12|Tests bit 4 of (hl).">bit 4,(hl)</td>
          <td axis="-0 1+ |2|8|Tests bit 4 of a.">bit 4,a</td>
          <td axis="-0 1+ |2|8|Tests bit 5 of b.">bit 5,b</td>
          <td axis="-0 1+ |2|8|Tests bit 5 of c.">bit 5,c</td>
          <td axis="-0 1+ |2|8|Tests bit 5 of d.">bit 5,d</td>
          <td axis="-0 1+ |2|8|Tests bit 5 of e.">bit 5,e</td>
          <td axis="-0 1+ |2|8|Tests bit 5 of h.">bit 5,h</td>
          <td axis="-0 1+ |2|8|Tests bit 5 of l.">bit 5,l</td>
          <td axis="-0 1+ |2|12|Tests bit 5 of (hl).">bit 5,(hl)</td>
          <td axis="-0 1+ |2|8|Tests bit 5 of a.">bit 5,a</td>
        </tr>
        <tr>
          <th>7</th>
          <td axis="-0 1+ |2|8|Tests bit 6 of b.">bit 6,b</td>
          <td axis="-0 1+ |2|8|Tests bit 6 of c.">bit 6,c</td>
          <td axis="-0 1+ |2|8|Tests bit 6 of d.">bit 6,d</td>
          <td axis="-0 1+ |2|8|Tests bit 6 of e.">bit 6,e</td>
          <td axis="-0 1+ |2|8|Tests bit 6 of h.">bit 6,h</td>
          <td axis="-0 1+ |2|8|Tests bit 6 of l.">bit 6,l</td>
          <td axis="-0 1+ |2|12|Tests bit 6 of (hl).">bit 6,(hl)</td>
          <td axis="-0 1+ |2|8|Tests bit 6 of a.">bit 6,a</td>
          <td axis="-0 1+ |2|8|Tests bit 7 of b.">bit 7,b</td>
          <td axis="-0 1+ |2|8|Tests bit 7 of c.">bit 7,c</td>
          <td axis="-0 1+ |2|8|Tests bit 7 of d.">bit 7,d</td>
          <td axis="-0 1+ |2|8|Tests bit 7 of e.">bit 7,e</td>
          <td axis="-0 1+ |2|8|Tests bit 7 of h.">bit 7,h</td>
          <td axis="-0 1+ |2|8|Tests bit 7 of l.">bit 7,l</td>
          <td axis="-0 1+ |2|12|Tests bit 7 of (hl).">bit 7,(hl)</td>
          <td axis="-0 1+ |2|8|Tests bit 7 of a.">bit 7,a</td>
        </tr>
        <tr>
          <th>8</th>
          <td axis="------|2|8|Resets bit 0 of b.">res 0,b</td>
          <td axis="------|2|8|Resets bit 0 of c.">res 0,c</td>
          <td axis="------|2|8|Resets bit 0 of d.">res 0,d</td>
          <td axis="------|2|8|Resets bit 0 of e.">res 0,e</td>
          <td axis="------|2|8|Resets bit 0 of h.">res 0,h</td>
          <td axis="------|2|8|Resets bit 0 of l.">res 0,l</td>
          <td axis="------|2|15|Resets bit 0 of (hl).">res 0,(hl)</td>
          <td axis="------|2|8|Resets bit 0 of a.">res 0,a</td>
          <td axis="------|2|8|Resets bit 1 of b.">res 1,b</td>
          <td axis="------|2|8|Resets bit 1 of c.">res 1,c</td>
          <td axis="------|2|8|Resets bit 1 of d.">res 1,d</td>
          <td axis="------|2|8|Resets bit 1 of e.">res 1,e</td>
          <td axis="------|2|8|Resets bit 1 of h.">res 1,h</td>
          <td axis="------|2|8|Resets bit 1 of l.">res 1,l</td>
          <td axis="------|2|15|Resets bit 1 of (hl).">res 1,(hl)</td>
          <td axis="------|2|8|Resets bit 1 of a.">res 1,a</td>
        </tr>
        <tr>
          <th>9</th>
          <td axis="------|2|8|Resets bit 2 of b.">res 2,b</td>
          <td axis="------|2|8|Resets bit 2 of c.">res 2,c</td>
          <td axis="------|2|8|Resets bit 2 of d.">res 2,d</td>
          <td axis="------|2|8|Resets bit 2 of e.">res 2,e</td>
          <td axis="------|2|8|Resets bit 2 of h.">res 2,h</td>
          <td axis="------|2|8|Resets bit 2 of l.">res 2,l</td>
          <td axis="------|2|15|Resets bit 2 of (hl).">res 2,(hl)</td>
          <td axis="------|2|8|Resets bit 2 of a.">res 2,a</td>
          <td axis="------|2|8|Resets bit 3 of b.">res 3,b</td>
          <td axis="------|2|8|Resets bit 3 of c.">res 3,c</td>
          <td axis="------|2|8|Resets bit 3 of d.">res 3,d</td>
          <td axis="------|2|8|Resets bit 3 of e.">res 3,e</td>
          <td axis="------|2|8|Resets bit 3 of h.">res 3,h</td>
          <td axis="------|2|8|Resets bit 3 of l.">res 3,l</td>
          <td axis="------|2|15|Resets bit 3 of (hl).">res 3,(hl)</td>
          <td axis="------|2|8|Resets bit 3 of a.">res 3,a</td>
        </tr>
        <tr>
          <th>A</th>
          <td axis="------|2|8|Resets bit 4 of b.">res 4,b</td>
          <td axis="------|2|8|Resets bit 4 of c.">res 4,c</td>
          <td axis="------|2|8|Resets bit 4 of d.">res 4,d</td>
          <td axis="------|2|8|Resets bit 4 of e.">res 4,e</td>
          <td axis="------|2|8|Resets bit 4 of h.">res 4,h</td>
          <td axis="------|2|8|Resets bit 4 of l.">res 4,l</td>
          <td axis="------|2|15|Resets bit 4 of (hl).">res 4,(hl)</td>
          <td axis="------|2|8|Resets bit 4 of a.">res 4,a</td>
          <td axis="------|2|8|Resets bit 5 of b.">res 5,b</td>
          <td axis="------|2|8|Resets bit 5 of c.">res 5,c</td>
          <td axis="------|2|8|Resets bit 5 of d.">res 5,d</td>
          <td axis="------|2|8|Resets bit 5 of e.">res 5,e</td>
          <td axis="------|2|8|Resets bit 5 of h.">res 5,h</td>
          <td axis="------|2|8|Resets bit 5 of l.">res 5,l</td>
          <td axis="------|2|15|Resets bit 5 of (hl).">res 5,(hl)</td>
          <td axis="------|2|8|Resets bit 5 of a.">res 5,a</td>
        </tr>
        <tr>
          <th>B</th>
          <td axis="------|2|8|Resets bit 6 of b.">res 6,b</td>
          <td axis="------|2|8|Resets bit 6 of c.">res 6,c</td>
          <td axis="------|2|8|Resets bit 6 of d.">res 6,d</td>
          <td axis="------|2|8|Resets bit 6 of e.">res 6,e</td>
          <td axis="------|2|8|Resets bit 6 of h.">res 6,h</td>
          <td axis="------|2|8|Resets bit 6 of l.">res 6,l</td>
          <td axis="------|2|15|Resets bit 6 of (hl).">res 6,(hl)</td>
          <td axis="------|2|8|Resets bit 6 of a.">res 6,a</td>
          <td axis="------|2|8|Resets bit 7 of b.">res 7,b</td>
          <td axis="------|2|8|Resets bit 7 of c.">res 7,c</td>
          <td axis="------|2|8|Resets bit 7 of d.">res 7,d</td>
          <td axis="------|2|8|Resets bit 7 of e.">res 7,e</td>
          <td axis="------|2|8|Resets bit 7 of h.">res 7,h</td>
          <td axis="------|2|8|Resets bit 7 of l.">res 7,l</td>
          <td axis="------|2|15|Resets bit 7 of (hl).">res 7,(hl)</td>
          <td axis="------|2|8|Resets bit 7 of a.">res 7,a</td>
        </tr>
        <tr>
          <th>C</th>
          <td axis="------|2|8|Sets bit 0 of b.">set 0,b</td>
          <td axis="------|2|8|Sets bit 0 of c.">set 0,c</td>
          <td axis="------|2|8|Sets bit 0 of d.">set 0,d</td>
          <td axis="------|2|8|Sets bit 0 of e.">set 0,e</td>
          <td axis="------|2|8|Sets bit 0 of h.">set 0,h</td>
          <td axis="------|2|8|Sets bit 0 of l.">set 0,l</td>
          <td axis="------|2|15|Sets bit 0 of (hl).">set 0,(hl)</td>
          <td axis="------|2|8|Sets bit 0 of a.">set 0,a</td>
          <td axis="------|2|8|Sets bit 1 of b.">set 1,b</td>
          <td axis="------|2|8|Sets bit 1 of c.">set 1,c</td>
          <td axis="------|2|8|Sets bit 1 of d.">set 1,d</td>
          <td axis="------|2|8|Sets bit 1 of e.">set 1,e</td>
          <td axis="------|2|8|Sets bit 1 of h.">set 1,h</td>
          <td axis="------|2|8|Sets bit 1 of l.">set 1,l</td>
          <td axis="------|2|15|Sets bit 1 of (hl).">set 1,(hl)</td>
          <td axis="------|2|8|Sets bit 1 of a.">set 1,a</td>
        </tr>
        <tr>
          <th>D</th>
          <td axis="------|2|8|Sets bit 2 of b.">set 2,b</td>
          <td axis="------|2|8|Sets bit 2 of c.">set 2,c</td>
          <td axis="------|2|8|Sets bit 2 of d.">set 2,d</td>
          <td axis="------|2|8|Sets bit 2 of e.">set 2,e</td>
          <td axis="------|2|8|Sets bit 2 of h.">set 2,h</td>
          <td axis="------|2|8|Sets bit 2 of l.">set 2,l</td>
          <td axis="------|2|15|Sets bit 2 of (hl).">set 2,(hl)</td>
          <td axis="------|2|8|Sets bit 2 of a.">set 2,a</td>
          <td axis="------|2|8|Sets bit 3 of b.">set 3,b</td>
          <td axis="------|2|8|Sets bit 3 of c.">set 3,c</td>
          <td axis="------|2|8|Sets bit 3 of d.">set 3,d</td>
          <td axis="------|2|8|Sets bit 3 of e.">set 3,e</td>
          <td axis="------|2|8|Sets bit 3 of h.">set 3,h</td>
          <td axis="------|2|8|Sets bit 3 of l.">set 3,l</td>
          <td axis="------|2|15|Sets bit 3 of (hl).">set 3,(hl)</td>
          <td axis="------|2|8|Sets bit 3 of a.">set 3,a</td>
        </tr>
        <tr>
          <th>E</th>
          <td axis="------|2|8|Sets bit 4 of b.">set 4,b</td>
          <td axis="------|2|8|Sets bit 4 of c.">set 4,c</td>
          <td axis="------|2|8|Sets bit 4 of d.">set 4,d</td>
          <td axis="------|2|8|Sets bit 4 of e.">set 4,e</td>
          <td axis="------|2|8|Sets bit 4 of h.">set 4,h</td>
          <td axis="------|2|8|Sets bit 4 of l.">set 4,l</td>
          <td axis="------|2|15|Sets bit 4 of (hl).">set 4,(hl)</td>
          <td axis="------|2|8|Sets bit 4 of a.">set 4,a</td>
          <td axis="------|2|8|Sets bit 5 of b.">set 5,b</td>
          <td axis="------|2|8|Sets bit 5 of c.">set 5,c</td>
          <td axis="------|2|8|Sets bit 5 of d.">set 5,d</td>
          <td axis="------|2|8|Sets bit 5 of e.">set 5,e</td>
          <td axis="------|2|8|Sets bit 5 of h.">set 5,h</td>
          <td axis="------|2|8|Sets bit 5 of l.">set 5,l</td>
          <td axis="------|2|15|Sets bit 5 of (hl).">set 5,(hl)</td>
          <td axis="------|2|8|Sets bit 5 of a.">set 5,a</td>
        </tr>
        <tr>
          <th>F</th>
          <td axis="------|2|8|Sets bit 6 of b.">set 6,b</td>
          <td axis="------|2|8|Sets bit 6 of c.">set 6,c</td>
          <td axis="------|2|8|Sets bit 6 of d.">set 6,d</td>
          <td axis="------|2|8|Sets bit 6 of e.">set 6,e</td>
          <td axis="------|2|8|Sets bit 6 of h.">set 6,h</td>
          <td axis="------|2|8|Sets bit 6 of l.">set 6,l</td>
          <td axis="------|2|15|Sets bit 6 of (hl).">set 6,(hl)</td>
          <td axis="------|2|8|Sets bit 6 of a.">set 6,a</td>
          <td axis="------|2|8|Sets bit 7 of b.">set 7,b</td>
          <td axis="------|2|8|Sets bit 7 of c.">set 7,c</td>
          <td axis="------|2|8|Sets bit 7 of d.">set 7,d</td>
          <td axis="------|2|8|Sets bit 7 of e.">set 7,e</td>
          <td axis="------|2|8|Sets bit 7 of h.">set 7,h</td>
          <td axis="------|2|8|Sets bit 7 of l.">set 7,l</td>
          <td axis="------|2|15|Sets bit 7 of (hl).">set 7,(hl)</td>
          <td axis="------|2|8|Sets bit 7 of a.">set 7,a</td>
        </tr>
      </table>
      <h3 id="table4">IX instructions (DD)</h3>
      <table title="DD">
        <tr>
          <td></td>
          <th>0</th>
          <th>1</th>
          <th>2</th>
          <th>3</th>
          <th>4</th>
          <th>5</th>
          <th>6</th>
          <th>7</th>
          <th>8</th>
          <th>9</th>
          <th>A</th>
          <th>B</th>
          <th>C</th>
          <th>D</th>
          <th>E</th>
          <th>F</th>
        </tr>
        <tr>
          <th>0</th>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td axis="++-+--|2|15|The value of bc is added to ix.">add ix,bc</td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <th>1</th>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td axis="++-+--|2|15|The value of de is added to ix.">add ix,de</td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <th>2</th>
          <td></td>
          <td axis="------|4|14|Loads ** into register ix.">ld ix,**</td>
          <td axis="------|4|20|Stores ix into the memory location pointed to by **.">ld (**),ix</td>
          <td axis="------|2|10|Adds one to ix.">inc ix</td>
          <td class="un" axis="-+V+++|2|8|Adds one to ixh.">inc ixh</td>
          <td class="un" axis="-+V+++|2|8|Subtracts one from ixh.">dec ixh</td>
          <td class="un" axis="------|3|11|Loads * into ixh.">ld ixh,*</td>
          <td></td>
          <td></td>
          <td axis="++-+--|2|15|The value of ix is added to ix.">add ix,ix</td>
          <td axis="------|4|20|Loads the value pointed to by ** into ix.">ld ix,(**)</td>
          <td axis="------|2|10|Subtracts one from ix.">dec ix</td>
          <td class="un" axis="-+V+++|2|8|Adds one to ixl.">inc ixl</td>
          <td class="un" axis="-+V+++|2|8|Subtracts one from ixl.">dec ixl</td>
          <td class="un" axis="------|3|11|Loads * into ixl.">ld ixl,*</td>
          <td></td>
        </tr>
        <tr>
          <th>3</th>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td axis="-+V+++|3|23|Adds one to the memory location pointed to by ix plus *.">inc (ix+*)</td>
          <td axis="-+V+++|3|23|Subtracts one from the memory location pointed to by ix plus *.">dec (ix+*)</td>
          <td axis="------|4|19|Stores * to the memory location pointed to by ix plus *.">ld (ix+*),*</td>
          <td></td>
          <td></td>
          <td axis="++-+--|2|15|The value of sp is added to ix.">add ix,sp</td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <th>4</th>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td class="un" axis="------|2|8|The contents of ixh are loaded into b.">ld b,ixh</td>
          <td class="un" axis="------|2|8|The contents of ixl are loaded into b.">ld b,ixl</td>
          <td axis="------|3|19|Loads the value pointed to by ix plus * into b.">ld b,(ix+*)</td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td class="un" axis="------|2|8|The contents of ixh are loaded into c.">ld c,ixh</td>
          <td class="un" axis="------|2|8|The contents of ixl are loaded into c.">ld c,ixl</td>
          <td axis="------|3|19|Loads the value pointed to by ix plus * into c.">ld c,(ix+*)</td>
          <td></td>
        </tr>
        <tr>
          <th>5</th>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td class="un" axis="------|2|8|The contents of ixh are loaded into d.">ld d,ixh</td>
          <td class="un" axis="------|2|8|The contents of ixl are loaded into d.">ld d,ixl</td>
          <td axis="------|3|19|Loads the value pointed to by ix plus * into d.">ld d,(ix+*)</td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td class="un" axis="------|2|8|The contents of ixh are loaded into e.">ld e,ixh</td>
          <td class="un" axis="------|2|8|The contents of ixl are loaded into e.">ld e,ixl</td>
          <td axis="------|3|19|Loads the value pointed to by ix plus * into e.">ld e,(ix+*)</td>
          <td></td>
        </tr>
        <tr>
          <th>6</th>
          <td class="un" axis="------|2|8|The contents of b are loaded into ixh.">ld ixh,b</td>
          <td class="un" axis="------|2|8|The contents of c are loaded into ixh.">ld ixh,c</td>
          <td class="un" axis="------|2|8|The contents of d are loaded into ixh.">ld ixh,d</td>
          <td class="un" axis="------|2|8|The contents of e are loaded into ixh.">ld ixh,e</td>
          <td class="un" axis="------|2|8|The contents of ixh are loaded into ixh.">ld ixh,ixh</td>
          <td class="un" axis="------|2|8|The contents of ixl are loaded into ixh.">ld ixh,ixl</td>
          <td axis="------|3|19|Loads the value pointed to by ix plus * into h.">ld h,(ix+*)</td>
          <td class="un" axis="------|2|8|The contents of a are loaded into ixh.">ld ixh,a</td>
          <td class="un" axis="------|2|8|The contents of b are loaded into ixl.">ld ixl,b</td>
          <td class="un" axis="------|2|8|The contents of c are loaded into ixl.">ld ixl,c</td>
          <td class="un" axis="------|2|8|The contents of d are loaded into ixl.">ld ixl,d</td>
          <td class="un" axis="------|2|8|The contents of e are loaded into ixl.">ld ixl,e</td>
          <td class="un" axis="------|2|8|The contents of ixh are loaded into ixl.">ld ixl,ixh</td>
          <td class="un" axis="------|2|8|The contents of ixl are loaded into ixl.">ld ixl,ixl</td>
          <td axis="------|3|19|Loads the value pointed to by ix plus * into l.">ld l,(ix+*)</td>
          <td class="un" axis="------|2|8|The contents of a are loaded into ixl.">ld ixl,a</td>
        </tr>
        <tr>
          <th>7</th>
          <td axis="------|3|19|Stores b to the memory location pointed to by ix plus *.">ld (ix+*),b</td>
          <td axis="------|3|19|Stores c to the memory location pointed to by ix plus *.">ld (ix+*),c</td>
          <td axis="------|3|19|Stores d to the memory location pointed to by ix plus *.">ld (ix+*),d</td>
          <td axis="------|3|19|Stores e to the memory location pointed to by ix plus *.">ld (ix+*),e</td>
          <td axis="------|3|19|Stores h to the memory location pointed to by ix plus *.">ld (ix+*),h</td>
          <td axis="------|3|19|Stores l to the memory location pointed to by ix plus *.">ld (ix+*),l</td>
          <td></td>
          <td axis="------|3|19|Stores a to the memory location pointed to by ix plus *.">ld (ix+*),a</td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td class="un" axis="------|2|8|The contents of ixh are loaded into a.">ld a,ixh</td>
          <td class="un" axis="------|2|8|The contents of ixl are loaded into a.">ld a,ixl</td>
          <td axis="------|3|19|Loads the value pointed to by ix plus * into a.">ld a,(ix+*)</td>
          <td></td>
        </tr>
        <tr>
          <th>8</th>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td class="un" axis="++V+++|2|8|Adds ixh to a.">add a,ixh</td>
          <td class="un" axis="++V+++|2|8|Adds ixl to a.">add a,ixl</td>
          <td axis="++V+++|3|19|Adds the value pointed to by ix plus * to a.">add a,(ix+*)</td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td class="un" axis="++V+++|2|8|Adds ixh and the carry flag to a.">adc a,ixh</td>
          <td class="un" axis="++V+++|2|8|Adds ixl and the carry flag to a.">adc a,ixl</td>
          <td axis="++V+++|3|19|Adds the value pointed to by ix plus * and the carry flag to a.">adc a,(ix+*)</td>
          <td></td>
        </tr>
        <tr>
          <th>9</th>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td class="un" axis="++V+++|2|8|Subtracts ixh from a.">sub ixh</td>
          <td class="un" axis="++V+++|2|8|Subtracts ixl from a.">sub ixl</td>
          <td axis="++V+++|3|19|Subtracts the value pointed to by ix plus * from a.">sub (ix+*)</td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td class="un" axis="++V+++|2|8|Subtracts ixh and the carry flag from a.">sbc a,ixh</td>
          <td class="un" axis="++V+++|2|8|Subtracts ixl and the carry flag from a.">sbc a,ixl</td>
          <td axis="++V+++|3|19|Subtracts the value pointed to by ix plus * and the carry flag from a.">sbc a,(ix+*)</td>
          <td></td>
        </tr>
        <tr>
          <th>A</th>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td class="un" axis="00P1++|2|8|Bitwise AND on a with ixh.">and ixh</td>
          <td class="un" axis="00P1++|2|8|Bitwise AND on a with ixl.">and ixl</td>
          <td axis="00P1++|3|19|Bitwise AND on a with the value pointed to by ix plus *.">and (ix+*)</td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td class="un" axis="00P0++|2|8|Bitwise XOR on a with ixh.">xor ixh</td>
          <td class="un" axis="00P0++|2|8|Bitwise XOR on a with ixl.">xor ixl</td>
          <td axis="00P0++|3|19|Bitwise XOR on a with the value pointed to by ix plus *.">xor (ix+*)</td>
          <td></td>
        </tr>
        <tr>
          <th>B</th>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td class="un" axis="00P0++|2|8|Bitwise OR on a with ixh.">or ixh</td>
          <td class="un" axis="00P0++|2|8|Bitwise OR on a with ixl.">or ixl</td>
          <td axis="00P0++|3|19|Bitwise OR on a with the value pointed to by ix plus *.">or (ix+*)</td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td class="un" axis="++V+++|2|8|Subtracts ixh from a and affects flags according to the result. a is not modified.">cp ixh</td>
          <td class="un" axis="++V+++|2|8|Subtracts ixl from a and affects flags according to the result. a is not modified.">cp ixl</td>
          <td axis="++V+++|3|19|Subtracts the value pointed to by ix plus * from a and affects flags according to the result. a is not modified.">cp (ix+*)</td>
          <td></td>
        </tr>
        <tr>
          <th>C</th>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td class="ln">
            <a href="#table5">IX BITS</a>
          </td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <th>D</th>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <th>E</th>
          <td></td>
          <td axis="------|2|14|The memory location pointed to by sp is stored into ixl and sp is incremented. The memory location pointed to by sp is stored into ixh and sp is incremented again.">pop ix</td>
          <td></td>
          <td axis="------|2|23|Exchanges (sp) with the ixl, and (sp+1) with the ixh.">ex (sp),ix</td>
          <td></td>
          <td axis="------|2|15|sp is decremented and ixh is stored into the memory location pointed to by sp. sp is decremented again and ixl is stored into the memory location pointed to by sp.">push ix</td>
          <td></td>
          <td></td>
          <td></td>
          <td axis="------|2|8|Loads the value of ix into pc.">jp (ix)</td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <th>F</th>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td axis="------|2|10|Loads the value of ix into sp.">ld sp,ix</td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
      </table>
      <h3 id="table5">IX bit instructions (DDCB)</h3>
      <table title="DDCB**">
        <tr>
          <td></td>
          <th>0</th>
          <th>1</th>
          <th>2</th>
          <th>3</th>
          <th>4</th>
          <th>5</th>
          <th>6</th>
          <th>7</th>
          <th>8</th>
          <th>9</th>
          <th>A</th>
          <th>B</th>
          <th>C</th>
          <th>D</th>
          <th>E</th>
          <th>F</th>
        </tr>
        <tr>
          <th>0</th>
          <td class="un" axis="+0P0++|4|23|The contents of the memory location pointed to by ix plus * are rotated left one bit position. The contents of bit 7 are copied to the carry flag and bit 0. The result is then stored in b.">rlc (ix+*),b</td>
          <td class="un" axis="+0P0++|4|23|The contents of the memory location pointed to by ix plus * are rotated left one bit position. The contents of bit 7 are copied to the carry flag and bit 0. The result is then stored in c.">rlc (ix+*),c</td>
          <td class="un" axis="+0P0++|4|23|The contents of the memory location pointed to by ix plus * are rotated left one bit position. The contents of bit 7 are copied to the carry flag and bit 0. The result is then stored in d.">rlc (ix+*),d</td>
          <td class="un" axis="+0P0++|4|23|The contents of the memory location pointed to by ix plus * are rotated left one bit position. The contents of bit 7 are copied to the carry flag and bit 0. The result is then stored in e.">rlc (ix+*),e</td>
          <td class="un" axis="+0P0++|4|23|The contents of the memory location pointed to by ix plus * are rotated left one bit position. The contents of bit 7 are copied to the carry flag and bit 0. The result is then stored in h.">rlc (ix+*),h</td>
          <td class="un" axis="+0P0++|4|23|The contents of the memory location pointed to by ix plus * are rotated left one bit position. The contents of bit 7 are copied to the carry flag and bit 0. The result is then stored in l.">rlc (ix+*),l</td>
          <td axis="+0P0++|4|23|The contents of the memory location pointed to by ix plus * are rotated left one bit position. The contents of bit 7 are copied to the carry flag and bit 0.">rlc (ix+*)</td>
          <td class="un" axis="+0P0++|4|23|The contents of the memory location pointed to by ix plus * are rotated left one bit position. The contents of bit 7 are copied to the carry flag and bit 0. The result is then stored in a.">rlc (ix+*),a</td>
          <td class="un" axis="+0P0++|4|23|The contents of the memory location pointed to by ix plus * are rotated right one bit position. The contents of bit 0 are copied to the carry flag and bit 7. The result is then stored in b.">rrc (ix+*),b</td>
          <td class="un" axis="+0P0++|4|23|The contents of the memory location pointed to by ix plus * are rotated right one bit position. The contents of bit 0 are copied to the carry flag and bit 7. The result is then stored in c.">rrc (ix+*),c</td>
          <td class="un" axis="+0P0++|4|23|The contents of the memory location pointed to by ix plus * are rotated right one bit position. The contents of bit 0 are copied to the carry flag and bit 7. The result is then stored in d.">rrc (ix+*),d</td>
          <td class="un" axis="+0P0++|4|23|The contents of the memory location pointed to by ix plus * are rotated right one bit position. The contents of bit 0 are copied to the carry flag and bit 7. The result is then stored in e.">rrc (ix+*),e</td>
          <td class="un" axis="+0P0++|4|23|The contents of the memory location pointed to by ix plus * are rotated right one bit position. The contents of bit 0 are copied to the carry flag and bit 7. The result is then stored in h.">rrc (ix+*),h</td>
          <td class="un" axis="+0P0++|4|23|The contents of the memory location pointed to by ix plus * are rotated right one bit position. The contents of bit 0 are copied to the carry flag and bit 7. The result is then stored in l.">rrc (ix+*),l</td>
          <td axis="+0P0++|4|23|The contents of the memory location pointed to by ix plus * are rotated right one bit position. The contents of bit 0 are copied to the carry flag and bit 7.">rrc (ix+*)</td>
          <td class="un" axis="+0P0++|4|23|The contents of the memory location pointed to by ix plus * are rotated right one bit position. The contents of bit 0 are copied to the carry flag and bit 7. The result is then stored in a.">rrc (ix+*),a</td>
        </tr>
        <tr>
          <th>1</th>
          <td class="un" axis="+0P0++|4|23|The contents of the memory location pointed to by ix plus * are rotated left one bit position. The contents of bit 7 are copied to the carry flag and the previous contents of the carry flag are copied to bit 0. The result is then stored in b.">rl (ix+*),b</td>
          <td class="un" axis="+0P0++|4|23|The contents of the memory location pointed to by ix plus * are rotated left one bit position. The contents of bit 7 are copied to the carry flag and the previous contents of the carry flag are copied to bit 0. The result is then stored in c.">rl (ix+*),c</td>
          <td class="un" axis="+0P0++|4|23|The contents of the memory location pointed to by ix plus * are rotated left one bit position. The contents of bit 7 are copied to the carry flag and the previous contents of the carry flag are copied to bit 0. The result is then stored in d.">rl (ix+*),d</td>
          <td class="un" axis="+0P0++|4|23|The contents of the memory location pointed to by ix plus * are rotated left one bit position. The contents of bit 7 are copied to the carry flag and the previous contents of the carry flag are copied to bit 0. The result is then stored in e.">rl (ix+*),e</td>
          <td class="un" axis="+0P0++|4|23|The contents of the memory location pointed to by ix plus * are rotated left one bit position. The contents of bit 7 are copied to the carry flag and the previous contents of the carry flag are copied to bit 0. The result is then stored in h.">rl (ix+*),h</td>
          <td class="un" axis="+0P0++|4|23|The contents of the memory location pointed to by ix plus * are rotated left one bit position. The contents of bit 7 are copied to the carry flag and the previous contents of the carry flag are copied to bit 0. The result is then stored in l.">rl (ix+*),l</td>
          <td axis="+0P0++|4|23|The contents of the memory location pointed to by ix plus * are rotated left one bit position. The contents of bit 7 are copied to the carry flag and the previous contents of the carry flag are copied to bit 0.">rl (ix+*)</td>
          <td class="un" axis="+0P0++|4|23|The contents of the memory location pointed to by ix plus * are rotated left one bit position. The contents of bit 7 are copied to the carry flag and the previous contents of the carry flag are copied to bit 0. The result is then stored in a.">rl (ix+*),a</td>
          <td class="un" axis="+0P0++|4|23|The contents of the memory location pointed to by ix plus * are rotated right one bit position. The contents of bit 0 are copied to the carry flag and the previous contents of the carry flag are copied to bit 7. The result is then stored in b.">rr (ix+*),b</td>
          <td class="un" axis="+0P0++|4|23|The contents of the memory location pointed to by ix plus * are rotated right one bit position. The contents of bit 0 are copied to the carry flag and the previous contents of the carry flag are copied to bit 7. The result is then stored in c.">rr (ix+*),c</td>
          <td class="un" axis="+0P0++|4|23|The contents of the memory location pointed to by ix plus * are rotated right one bit position. The contents of bit 0 are copied to the carry flag and the previous contents of the carry flag are copied to bit 7. The result is then stored in d.">rr (ix+*),d</td>
          <td class="un" axis="+0P0++|4|23|The contents of the memory location pointed to by ix plus * are rotated right one bit position. The contents of bit 0 are copied to the carry flag and the previous contents of the carry flag are copied to bit 7. The result is then stored in e.">rr (ix+*),e</td>
          <td class="un" axis="+0P0++|4|23|The contents of the memory location pointed to by ix plus * are rotated right one bit position. The contents of bit 0 are copied to the carry flag and the previous contents of the carry flag are copied to bit 7. The result is then stored in h.">rr (ix+*),h</td>
          <td class="un" axis="+0P0++|4|23|The contents of the memory location pointed to by ix plus * are rotated right one bit position. The contents of bit 0 are copied to the carry flag and the previous contents of the carry flag are copied to bit 7. The result is then stored in l.">rr (ix+*),l</td>
          <td axis="+0P0++|4|23|The contents of the memory location pointed to by ix plus * are rotated right one bit position. The contents of bit 0 are copied to the carry flag and the previous contents of the carry flag are copied to bit 7.">rr (ix+*)</td>
          <td class="un" axis="+0P0++|4|23|The contents of the memory location pointed to by ix plus * are rotated right one bit position. The contents of bit 0 are copied to the carry flag and the previous contents of the carry flag are copied to bit 7. The result is then stored in a.">rr (ix+*),a</td>
        </tr>
        <tr>
          <th>2</th>
          <td class="un" axis="+0P0++|4|23|The contents of the memory location pointed to by ix plus * are shifted left one bit position. The contents of bit 7 are copied to the carry flag and a zero is put into bit 0. The result is then stored in b.">sla (ix+*),b</td>
          <td class="un" axis="+0P0++|4|23|The contents of the memory location pointed to by ix plus * are shifted left one bit position. The contents of bit 7 are copied to the carry flag and a zero is put into bit 0. The result is then stored in c.">sla (ix+*),c</td>
          <td class="un" axis="+0P0++|4|23|The contents of the memory location pointed to by ix plus * are shifted left one bit position. The contents of bit 7 are copied to the carry flag and a zero is put into bit 0. The result is then stored in d.">sla (ix+*),d</td>
          <td class="un" axis="+0P0++|4|23|The contents of the memory location pointed to by ix plus * are shifted left one bit position. The contents of bit 7 are copied to the carry flag and a zero is put into bit 0. The result is then stored in e.">sla (ix+*),e</td>
          <td class="un" axis="+0P0++|4|23|The contents of the memory location pointed to by ix plus * are shifted left one bit position. The contents of bit 7 are copied to the carry flag and a zero is put into bit 0. The result is then stored in h.">sla (ix+*),h</td>
          <td class="un" axis="+0P0++|4|23|The contents of the memory location pointed to by ix plus * are shifted left one bit position. The contents of bit 7 are copied to the carry flag and a zero is put into bit 0. The result is then stored in l.">sla (ix+*),l</td>
          <td axis="+0P0++|4|23|The contents of the memory location pointed to by ix plus * are shifted left one bit position. The contents of bit 7 are copied to the carry flag and a zero is put into bit 0.">sla (ix+*)</td>
          <td class="un" axis="+0P0++|4|23|The contents of the memory location pointed to by ix plus * are shifted left one bit position. The contents of bit 7 are copied to the carry flag and a zero is put into bit 0. The result is then stored in a.">sla (ix+*),a</td>
          <td class="un" axis="+0P0++|4|23|The contents of the memory location pointed to by ix plus * are shifted right one bit position. The contents of bit 0 are copied to the carry flag and the previous contents of bit 7 are unchanged. The result is then stored in b.">sra (ix+*),b</td>
          <td class="un" axis="+0P0++|4|23|The contents of the memory location pointed to by ix plus * are shifted right one bit position. The contents of bit 0 are copied to the carry flag and the previous contents of bit 7 are unchanged. The result is then stored in c.">sra (ix+*),c</td>
          <td class="un" axis="+0P0++|4|23|The contents of the memory location pointed to by ix plus * are shifted right one bit position. The contents of bit 0 are copied to the carry flag and the previous contents of bit 7 are unchanged. The result is then stored in d.">sra (ix+*),d</td>
          <td class="un" axis="+0P0++|4|23|The contents of the memory location pointed to by ix plus * are shifted right one bit position. The contents of bit 0 are copied to the carry flag and the previous contents of bit 7 are unchanged. The result is then stored in e.">sra (ix+*),e</td>
          <td class="un" axis="+0P0++|4|23|The contents of the memory location pointed to by ix plus * are shifted right one bit position. The contents of bit 0 are copied to the carry flag and the previous contents of bit 7 are unchanged. The result is then stored in h.">sra (ix+*),h</td>
          <td class="un" axis="+0P0++|4|23|The contents of the memory location pointed to by ix plus * are shifted right one bit position. The contents of bit 0 are copied to the carry flag and the previous contents of bit 7 are unchanged. The result is then stored in l.">sra (ix+*),l</td>
          <td axis="+0P0++|4|23|The contents of the memory location pointed to by ix plus * are shifted right one bit position. The contents of bit 0 are copied to the carry flag and the previous contents of bit 7 are unchanged.">sra (ix+*)</td>
          <td class="un" axis="+0P0++|4|23|The contents of the memory location pointed to by ix plus * are shifted right one bit position. The contents of bit 0 are copied to the carry flag and the previous contents of bit 7 are unchanged. The result is then stored in a.">sra (ix+*),a</td>
        </tr>
        <tr>
          <th>3</th>
          <td class="un" axis="+0P0++|4|23|The contents of the memory location pointed to by ix plus * are shifted left one bit position. The contents of bit 7 are put into the carry flag and a one is put into bit 0. The result is then stored in b.">sll (ix+*),b</td>
          <td class="un" axis="+0P0++|4|23|The contents of the memory location pointed to by ix plus * are shifted left one bit position. The contents of bit 7 are put into the carry flag and a one is put into bit 0. The result is then stored in c.">sll (ix+*),c</td>
          <td class="un" axis="+0P0++|4|23|The contents of the memory location pointed to by ix plus * are shifted left one bit position. The contents of bit 7 are put into the carry flag and a one is put into bit 0. The result is then stored in d.">sll (ix+*),d</td>
          <td class="un" axis="+0P0++|4|23|The contents of the memory location pointed to by ix plus * are shifted left one bit position. The contents of bit 7 are put into the carry flag and a one is put into bit 0. The result is then stored in e.">sll (ix+*),e</td>
          <td class="un" axis="+0P0++|4|23|The contents of the memory location pointed to by ix plus * are shifted left one bit position. The contents of bit 7 are put into the carry flag and a one is put into bit 0. The result is then stored in h.">sll (ix+*),h</td>
          <td class="un" axis="+0P0++|4|23|The contents of the memory location pointed to by ix plus * are shifted left one bit position. The contents of bit 7 are put into the carry flag and a one is put into bit 0. The result is then stored in l.">sll (ix+*),l</td>
          <td class="un" axis="+0P0++|4|23|The contents of the memory location pointed to by ix plus * are shifted left one bit position. The contents of bit 7 are put into the carry flag and a one is put into bit 0.">sll (ix+*)</td>
          <td class="un" axis="+0P0++|4|23|The contents of the memory location pointed to by ix plus * are shifted left one bit position. The contents of bit 7 are put into the carry flag and a one is put into bit 0. The result is then stored in a.">sll (ix+*),a</td>
          <td class="un" axis="+0P0++|4|23|The contents of the memory location pointed to by ix plus * are shifted right one bit position. The contents of bit 0 are copied to the carry flag and a zero is put into bit 7. The result is then stored in b.">srl (ix+*),b</td>
          <td class="un" axis="+0P0++|4|23|The contents of the memory location pointed to by ix plus * are shifted right one bit position. The contents of bit 0 are copied to the carry flag and a zero is put into bit 7. The result is then stored in c.">srl (ix+*),c</td>
          <td class="un" axis="+0P0++|4|23|The contents of the memory location pointed to by ix plus * are shifted right one bit position. The contents of bit 0 are copied to the carry flag and a zero is put into bit 7. The result is then stored in d.">srl (ix+*),d</td>
          <td class="un" axis="+0P0++|4|23|The contents of the memory location pointed to by ix plus * are shifted right one bit position. The contents of bit 0 are copied to the carry flag and a zero is put into bit 7. The result is then stored in e.">srl (ix+*),e</td>
          <td class="un" axis="+0P0++|4|23|The contents of the memory location pointed to by ix plus * are shifted right one bit position. The contents of bit 0 are copied to the carry flag and a zero is put into bit 7. The result is then stored in h.">srl (ix+*),h</td>
          <td class="un" axis="+0P0++|4|23|The contents of the memory location pointed to by ix plus * are shifted right one bit position. The contents of bit 0 are copied to the carry flag and a zero is put into bit 7. The result is then stored in l.">srl (ix+*),l</td>
          <td axis="+0P0++|4|23|The contents of the memory location pointed to by ix plus * are shifted right one bit position. The contents of bit 0 are copied to the carry flag and a zero is put into bit 7.">srl (ix+*)</td>
          <td class="un" axis="+0P0++|4|23|The contents of the memory location pointed to by ix plus * are shifted right one bit position. The contents of bit 0 are copied to the carry flag and a zero is put into bit 7. The result is then stored in a.">srl (ix+*),a</td>
        </tr>
        <tr>
          <th>4</th>
          <td class="un" axis="-0 1+ |4|20|Tests bit 0 of the memory location pointed to by ix plus *.">bit 0,(ix+*)</td>
          <td class="un" axis="-0 1+ |4|20|Tests bit 0 of the memory location pointed to by ix plus *.">bit 0,(ix+*)</td>
          <td class="un" axis="-0 1+ |4|20|Tests bit 0 of the memory location pointed to by ix plus *.">bit 0,(ix+*)</td>
          <td class="un" axis="-0 1+ |4|20|Tests bit 0 of the memory location pointed to by ix plus *.">bit 0,(ix+*)</td>
          <td class="un" axis="-0 1+ |4|20|Tests bit 0 of the memory location pointed to by ix plus *.">bit 0,(ix+*)</td>
          <td class="un" axis="-0 1+ |4|20|Tests bit 0 of the memory location pointed to by ix plus *.">bit 0,(ix+*)</td>
          <td axis="-0 1+ |4|20|Tests bit 0 of the memory location pointed to by ix plus *.">bit 0,(ix+*)</td>
          <td class="un" axis="-0 1+ |4|20|Tests bit 0 of the memory location pointed to by ix plus *.">bit 0,(ix+*)</td>
          <td class="un" axis="-0 1+ |4|20|Tests bit 1 of the memory location pointed to by ix plus *.">bit 1,(ix+*)</td>
          <td class="un" axis="-0 1+ |4|20|Tests bit 1 of the memory location pointed to by ix plus *.">bit 1,(ix+*)</td>
          <td class="un" axis="-0 1+ |4|20|Tests bit 1 of the memory location pointed to by ix plus *.">bit 1,(ix+*)</td>
          <td class="un" axis="-0 1+ |4|20|Tests bit 1 of the memory location pointed to by ix plus *.">bit 1,(ix+*)</td>
          <td class="un" axis="-0 1+ |4|20|Tests bit 1 of the memory location pointed to by ix plus *.">bit 1,(ix+*)</td>
          <td class="un" axis="-0 1+ |4|20|Tests bit 1 of the memory location pointed to by ix plus *.">bit 1,(ix+*)</td>
          <td axis="-0 1+ |4|20|Tests bit 1 of the memory location pointed to by ix plus *.">bit 1,(ix+*)</td>
          <td class="un" axis="-0 1+ |4|20|Tests bit 1 of the memory location pointed to by ix plus *.">bit 1,(ix+*)</td>
        </tr>
        <tr>
          <th>5</th>
          <td class="un" axis="-0 1+ |4|20|Tests bit 2 of the memory location pointed to by ix plus *.">bit 2,(ix+*)</td>
          <td class="un" axis="-0 1+ |4|20|Tests bit 2 of the memory location pointed to by ix plus *.">bit 2,(ix+*)</td>
          <td class="un" axis="-0 1+ |4|20|Tests bit 2 of the memory location pointed to by ix plus *.">bit 2,(ix+*)</td>
          <td class="un" axis="-0 1+ |4|20|Tests bit 2 of the memory location pointed to by ix plus *.">bit 2,(ix+*)</td>
          <td class="un" axis="-0 1+ |4|20|Tests bit 2 of the memory location pointed to by ix plus *.">bit 2,(ix+*)</td>
          <td class="un" axis="-0 1+ |4|20|Tests bit 2 of the memory location pointed to by ix plus *.">bit 2,(ix+*)</td>
          <td axis="-0 1+ |4|20|Tests bit 2 of the memory location pointed to by ix plus *.">bit 2,(ix+*)</td>
          <td class="un" axis="-0 1+ |4|20|Tests bit 2 of the memory location pointed to by ix plus *.">bit 2,(ix+*)</td>
          <td class="un" axis="-0 1+ |4|20|Tests bit 3 of the memory location pointed to by ix plus *.">bit 3,(ix+*)</td>
          <td class="un" axis="-0 1+ |4|20|Tests bit 3 of the memory location pointed to by ix plus *.">bit 3,(ix+*)</td>
          <td class="un" axis="-0 1+ |4|20|Tests bit 3 of the memory location pointed to by ix plus *.">bit 3,(ix+*)</td>
          <td class="un" axis="-0 1+ |4|20|Tests bit 3 of the memory location pointed to by ix plus *.">bit 3,(ix+*)</td>
          <td class="un" axis="-0 1+ |4|20|Tests bit 3 of the memory location pointed to by ix plus *.">bit 3,(ix+*)</td>
          <td class="un" axis="-0 1+ |4|20|Tests bit 3 of the memory location pointed to by ix plus *.">bit 3,(ix+*)</td>
          <td axis="-0 1+ |4|20|Tests bit 3 of the memory location pointed to by ix plus *.">bit 3,(ix+*)</td>
          <td class="un" axis="-0 1+ |4|20|Tests bit 3 of the memory location pointed to by ix plus *.">bit 3,(ix+*)</td>
        </tr>
        <tr>
          <th>6</th>
          <td class="un" axis="-0 1+ |4|20|Tests bit 4 of the memory location pointed to by ix plus *.">bit 4,(ix+*)</td>
          <td class="un" axis="-0 1+ |4|20|Tests bit 4 of the memory location pointed to by ix plus *.">bit 4,(ix+*)</td>
          <td class="un" axis="-0 1+ |4|20|Tests bit 4 of the memory location pointed to by ix plus *.">bit 4,(ix+*)</td>
          <td class="un" axis="-0 1+ |4|20|Tests bit 4 of the memory location pointed to by ix plus *.">bit 4,(ix+*)</td>
          <td class="un" axis="-0 1+ |4|20|Tests bit 4 of the memory location pointed to by ix plus *.">bit 4,(ix+*)</td>
          <td class="un" axis="-0 1+ |4|20|Tests bit 4 of the memory location pointed to by ix plus *.">bit 4,(ix+*)</td>
          <td axis="-0 1+ |4|20|Tests bit 4 of the memory location pointed to by ix plus *.">bit 4,(ix+*)</td>
          <td class="un" axis="-0 1+ |4|20|Tests bit 4 of the memory location pointed to by ix plus *.">bit 4,(ix+*)</td>
          <td class="un" axis="-0 1+ |4|20|Tests bit 5 of the memory location pointed to by ix plus *.">bit 5,(ix+*)</td>
          <td class="un" axis="-0 1+ |4|20|Tests bit 5 of the memory location pointed to by ix plus *.">bit 5,(ix+*)</td>
          <td class="un" axis="-0 1+ |4|20|Tests bit 5 of the memory location pointed to by ix plus *.">bit 5,(ix+*)</td>
          <td class="un" axis="-0 1+ |4|20|Tests bit 5 of the memory location pointed to by ix plus *.">bit 5,(ix+*)</td>
          <td class="un" axis="-0 1+ |4|20|Tests bit 5 of the memory location pointed to by ix plus *.">bit 5,(ix+*)</td>
          <td class="un" axis="-0 1+ |4|20|Tests bit 5 of the memory location pointed to by ix plus *.">bit 5,(ix+*)</td>
          <td axis="-0 1+ |4|20|Tests bit 5 of the memory location pointed to by ix plus *.">bit 5,(ix+*)</td>
          <td class="un" axis="-0 1+ |4|20|Tests bit 5 of the memory location pointed to by ix plus *.">bit 5,(ix+*)</td>
        </tr>
        <tr>
          <th>7</th>
          <td class="un" axis="-0 1+ |4|20|Tests bit 6 of the memory location pointed to by ix plus *.">bit 6,(ix+*)</td>
          <td class="un" axis="-0 1+ |4|20|Tests bit 6 of the memory location pointed to by ix plus *.">bit 6,(ix+*)</td>
          <td class="un" axis="-0 1+ |4|20|Tests bit 6 of the memory location pointed to by ix plus *.">bit 6,(ix+*)</td>
          <td class="un" axis="-0 1+ |4|20|Tests bit 6 of the memory location pointed to by ix plus *.">bit 6,(ix+*)</td>
          <td class="un" axis="-0 1+ |4|20|Tests bit 6 of the memory location pointed to by ix plus *.">bit 6,(ix+*)</td>
          <td class="un" axis="-0 1+ |4|20|Tests bit 6 of the memory location pointed to by ix plus *.">bit 6,(ix+*)</td>
          <td axis="-0 1+ |4|20|Tests bit 6 of the memory location pointed to by ix plus *.">bit 6,(ix+*)</td>
          <td class="un" axis="-0 1+ |4|20|Tests bit 6 of the memory location pointed to by ix plus *.">bit 6,(ix+*)</td>
          <td class="un" axis="-0 1+ |4|20|Tests bit 7 of the memory location pointed to by ix plus *.">bit 7,(ix+*)</td>
          <td class="un" axis="-0 1+ |4|20|Tests bit 7 of the memory location pointed to by ix plus *.">bit 7,(ix+*)</td>
          <td class="un" axis="-0 1+ |4|20|Tests bit 7 of the memory location pointed to by ix plus *.">bit 7,(ix+*)</td>
          <td class="un" axis="-0 1+ |4|20|Tests bit 7 of the memory location pointed to by ix plus *.">bit 7,(ix+*)</td>
          <td class="un" axis="-0 1+ |4|20|Tests bit 7 of the memory location pointed to by ix plus *.">bit 7,(ix+*)</td>
          <td class="un" axis="-0 1+ |4|20|Tests bit 7 of the memory location pointed to by ix plus *.">bit 7,(ix+*)</td>
          <td axis="-0 1+ |4|20|Tests bit 7 of the memory location pointed to by ix plus *.">bit 7,(ix+*)</td>
          <td class="un" axis="-0 1+ |4|20|Tests bit 7 of the memory location pointed to by ix plus *.">bit 7,(ix+*)</td>
        </tr>
        <tr>
          <th>8</th>
          <td class="un" axis="------|4|23|Resets bit 0 of the memory location pointed to by ix plus *.">res 0,(ix+*),b</td>
          <td class="un" axis="------|4|23|Resets bit 0 of the memory location pointed to by ix plus *.">res 0,(ix+*),c</td>
          <td class="un" axis="------|4|23|Resets bit 0 of the memory location pointed to by ix plus *.">res 0,(ix+*),d</td>
          <td class="un" axis="------|4|23|Resets bit 0 of the memory location pointed to by ix plus *.">res 0,(ix+*),e</td>
          <td class="un" axis="------|4|23|Resets bit 0 of the memory location pointed to by ix plus *.">res 0,(ix+*),h</td>
          <td class="un" axis="------|4|23|Resets bit 0 of the memory location pointed to by ix plus *.">res 0,(ix+*),l</td>
          <td axis="------|4|23|Resets bit 0 of the memory location pointed to by ix plus *.">res 0,(ix+*)</td>
          <td class="un" axis="------|4|23|Resets bit 0 of the memory location pointed to by ix plus *.">res 0,(ix+*),a</td>
          <td class="un" axis="------|4|23|Resets bit 1 of the memory location pointed to by ix plus *.">res 1,(ix+*),b</td>
          <td class="un" axis="------|4|23|Resets bit 1 of the memory location pointed to by ix plus *.">res 1,(ix+*),c</td>
          <td class="un" axis="------|4|23|Resets bit 1 of the memory location pointed to by ix plus *.">res 1,(ix+*),d</td>
          <td class="un" axis="------|4|23|Resets bit 1 of the memory location pointed to by ix plus *.">res 1,(ix+*),e</td>
          <td class="un" axis="------|4|23|Resets bit 1 of the memory location pointed to by ix plus *.">res 1,(ix+*),h</td>
          <td class="un" axis="------|4|23|Resets bit 1 of the memory location pointed to by ix plus *.">res 1,(ix+*),l</td>
          <td axis="------|4|23|Resets bit 1 of the memory location pointed to by ix plus *.">res 1,(ix+*)</td>
          <td class="un" axis="------|4|23|Resets bit 1 of the memory location pointed to by ix plus *.">res 1,(ix+*),a</td>
        </tr>
        <tr>
          <th>9</th>
          <td class="un" axis="------|4|23|Resets bit 2 of the memory location pointed to by ix plus *.">res 2,(ix+*),b</td>
          <td class="un" axis="------|4|23|Resets bit 2 of the memory location pointed to by ix plus *.">res 2,(ix+*),c</td>
          <td class="un" axis="------|4|23|Resets bit 2 of the memory location pointed to by ix plus *.">res 2,(ix+*),d</td>
          <td class="un" axis="------|4|23|Resets bit 2 of the memory location pointed to by ix plus *.">res 2,(ix+*),e</td>
          <td class="un" axis="------|4|23|Resets bit 2 of the memory location pointed to by ix plus *.">res 2,(ix+*),h</td>
          <td class="un" axis="------|4|23|Resets bit 2 of the memory location pointed to by ix plus *.">res 2,(ix+*),l</td>
          <td axis="------|4|23|Resets bit 2 of the memory location pointed to by ix plus *.">res 2,(ix+*)</td>
          <td class="un" axis="------|4|23|Resets bit 2 of the memory location pointed to by ix plus *.">res 2,(ix+*),a</td>
          <td class="un" axis="------|4|23|Resets bit 3 of the memory location pointed to by ix plus *.">res 3,(ix+*),b</td>
          <td class="un" axis="------|4|23|Resets bit 3 of the memory location pointed to by ix plus *.">res 3,(ix+*),c</td>
          <td class="un" axis="------|4|23|Resets bit 3 of the memory location pointed to by ix plus *.">res 3,(ix+*),d</td>
          <td class="un" axis="------|4|23|Resets bit 3 of the memory location pointed to by ix plus *.">res 3,(ix+*),e</td>
          <td class="un" axis="------|4|23|Resets bit 3 of the memory location pointed to by ix plus *.">res 3,(ix+*),h</td>
          <td class="un" axis="------|4|23|Resets bit 3 of the memory location pointed to by ix plus *.">res 3,(ix+*),l</td>
          <td axis="------|4|23|Resets bit 3 of the memory location pointed to by ix plus *.">res 3,(ix+*)</td>
          <td class="un" axis="------|4|23|Resets bit 3 of the memory location pointed to by ix plus *.">res 3,(ix+*),a</td>
        </tr>
        <tr>
          <th>A</th>
          <td class="un" axis="------|4|23|Resets bit 4 of the memory location pointed to by ix plus *.">res 4,(ix+*),b</td>
          <td class="un" axis="------|4|23|Resets bit 4 of the memory location pointed to by ix plus *.">res 4,(ix+*),c</td>
          <td class="un" axis="------|4|23|Resets bit 4 of the memory location pointed to by ix plus *.">res 4,(ix+*),d</td>
          <td class="un" axis="------|4|23|Resets bit 4 of the memory location pointed to by ix plus *.">res 4,(ix+*),e</td>
          <td class="un" axis="------|4|23|Resets bit 4 of the memory location pointed to by ix plus *.">res 4,(ix+*),h</td>
          <td class="un" axis="------|4|23|Resets bit 4 of the memory location pointed to by ix plus *.">res 4,(ix+*),l</td>
          <td axis="------|4|23|Resets bit 4 of the memory location pointed to by ix plus *.">res 4,(ix+*)</td>
          <td class="un" axis="------|4|23|Resets bit 4 of the memory location pointed to by ix plus *.">res 4,(ix+*),a</td>
          <td class="un" axis="------|4|23|Resets bit 5 of the memory location pointed to by ix plus *.">res 5,(ix+*),b</td>
          <td class="un" axis="------|4|23|Resets bit 5 of the memory location pointed to by ix plus *.">res 5,(ix+*),c</td>
          <td class="un" axis="------|4|23|Resets bit 5 of the memory location pointed to by ix plus *.">res 5,(ix+*),d</td>
          <td class="un" axis="------|4|23|Resets bit 5 of the memory location pointed to by ix plus *.">res 5,(ix+*),e</td>
          <td class="un" axis="------|4|23|Resets bit 5 of the memory location pointed to by ix plus *.">res 5,(ix+*),h</td>
          <td class="un" axis="------|4|23|Resets bit 5 of the memory location pointed to by ix plus *.">res 5,(ix+*),l</td>
          <td axis="------|4|23|Resets bit 5 of the memory location pointed to by ix plus *.">res 5,(ix+*)</td>
          <td class="un" axis="------|4|23|Resets bit 5 of the memory location pointed to by ix plus *.">res 5,(ix+*),a</td>
        </tr>
        <tr>
          <th>B</th>
          <td class="un" axis="------|4|23|Resets bit 6 of the memory location pointed to by ix plus *.">res 6,(ix+*),b</td>
          <td class="un" axis="------|4|23|Resets bit 6 of the memory location pointed to by ix plus *.">res 6,(ix+*),c</td>
          <td class="un" axis="------|4|23|Resets bit 6 of the memory location pointed to by ix plus *.">res 6,(ix+*),d</td>
          <td class="un" axis="------|4|23|Resets bit 6 of the memory location pointed to by ix plus *.">res 6,(ix+*),e</td>
          <td class="un" axis="------|4|23|Resets bit 6 of the memory location pointed to by ix plus *.">res 6,(ix+*),h</td>
          <td class="un" axis="------|4|23|Resets bit 6 of the memory location pointed to by ix plus *.">res 6,(ix+*),l</td>
          <td axis="------|4|23|Resets bit 6 of the memory location pointed to by ix plus *.">res 6,(ix+*)</td>
          <td class="un" axis="------|4|23|Resets bit 6 of the memory location pointed to by ix plus *.">res 6,(ix+*),a</td>
          <td class="un" axis="------|4|23|Resets bit 7 of the memory location pointed to by ix plus *.">res 7,(ix+*),b</td>
          <td class="un" axis="------|4|23|Resets bit 7 of the memory location pointed to by ix plus *.">res 7,(ix+*),c</td>
          <td class="un" axis="------|4|23|Resets bit 7 of the memory location pointed to by ix plus *.">res 7,(ix+*),d</td>
          <td class="un" axis="------|4|23|Resets bit 7 of the memory location pointed to by ix plus *.">res 7,(ix+*),e</td>
          <td class="un" axis="------|4|23|Resets bit 7 of the memory location pointed to by ix plus *.">res 7,(ix+*),h</td>
          <td class="un" axis="------|4|23|Resets bit 7 of the memory location pointed to by ix plus *.">res 7,(ix+*),l</td>
          <td axis="------|4|23|Resets bit 7 of the memory location pointed to by ix plus *.">res 7,(ix+*)</td>
          <td class="un" axis="------|4|23|Resets bit 7 of the memory location pointed to by ix plus *.">res 7,(ix+*),a</td>
        </tr>
        <tr>
          <th>C</th>
          <td class="un" axis="------|4|23|Sets bit 0 of the memory location pointed to by ix plus *.">set 0,(ix+*),b</td>
          <td class="un" axis="------|4|23|Sets bit 0 of the memory location pointed to by ix plus *.">set 0,(ix+*),c</td>
          <td class="un" axis="------|4|23|Sets bit 0 of the memory location pointed to by ix plus *.">set 0,(ix+*),d</td>
          <td class="un" axis="------|4|23|Sets bit 0 of the memory location pointed to by ix plus *.">set 0,(ix+*),e</td>
          <td class="un" axis="------|4|23|Sets bit 0 of the memory location pointed to by ix plus *.">set 0,(ix+*),h</td>
          <td class="un" axis="------|4|23|Sets bit 0 of the memory location pointed to by ix plus *.">set 0,(ix+*),l</td>
          <td axis="------|4|23|Sets bit 0 of the memory location pointed to by ix plus *.">set 0,(ix+*)</td>
          <td class="un" axis="------|4|23|Sets bit 0 of the memory location pointed to by ix plus *.">set 0,(ix+*),a</td>
          <td class="un" axis="------|4|23|Sets bit 1 of the memory location pointed to by ix plus *.">set 1,(ix+*),b</td>
          <td class="un" axis="------|4|23|Sets bit 1 of the memory location pointed to by ix plus *.">set 1,(ix+*),c</td>
          <td class="un" axis="------|4|23|Sets bit 1 of the memory location pointed to by ix plus *.">set 1,(ix+*),d</td>
          <td class="un" axis="------|4|23|Sets bit 1 of the memory location pointed to by ix plus *.">set 1,(ix+*),e</td>
          <td class="un" axis="------|4|23|Sets bit 1 of the memory location pointed to by ix plus *.">set 1,(ix+*),h</td>
          <td class="un" axis="------|4|23|Sets bit 1 of the memory location pointed to by ix plus *.">set 1,(ix+*),l</td>
          <td axis="------|4|23|Sets bit 1 of the memory location pointed to by ix plus *.">set 1,(ix+*)</td>
          <td class="un" axis="------|4|23|Sets bit 1 of the memory location pointed to by ix plus *.">set 1,(ix+*),a</td>
        </tr>
        <tr>
          <th>D</th>
          <td class="un" axis="------|4|23|Sets bit 2 of the memory location pointed to by ix plus *.">set 2,(ix+*),b</td>
          <td class="un" axis="------|4|23|Sets bit 2 of the memory location pointed to by ix plus *.">set 2,(ix+*),c</td>
          <td class="un" axis="------|4|23|Sets bit 2 of the memory location pointed to by ix plus *.">set 2,(ix+*),d</td>
          <td class="un" axis="------|4|23|Sets bit 2 of the memory location pointed to by ix plus *.">set 2,(ix+*),e</td>
          <td class="un" axis="------|4|23|Sets bit 2 of the memory location pointed to by ix plus *.">set 2,(ix+*),h</td>
          <td class="un" axis="------|4|23|Sets bit 2 of the memory location pointed to by ix plus *.">set 2,(ix+*),l</td>
          <td axis="------|4|23|Sets bit 2 of the memory location pointed to by ix plus *.">set 2,(ix+*)</td>
          <td class="un" axis="------|4|23|Sets bit 2 of the memory location pointed to by ix plus *.">set 2,(ix+*),a</td>
          <td class="un" axis="------|4|23|Sets bit 3 of the memory location pointed to by ix plus *.">set 3,(ix+*),b</td>
          <td class="un" axis="------|4|23|Sets bit 3 of the memory location pointed to by ix plus *.">set 3,(ix+*),c</td>
          <td class="un" axis="------|4|23|Sets bit 3 of the memory location pointed to by ix plus *.">set 3,(ix+*),d</td>
          <td class="un" axis="------|4|23|Sets bit 3 of the memory location pointed to by ix plus *.">set 3,(ix+*),e</td>
          <td class="un" axis="------|4|23|Sets bit 3 of the memory location pointed to by ix plus *.">set 3,(ix+*),h</td>
          <td class="un" axis="------|4|23|Sets bit 3 of the memory location pointed to by ix plus *.">set 3,(ix+*),l</td>
          <td axis="------|4|23|Sets bit 3 of the memory location pointed to by ix plus *.">set 3,(ix+*)</td>
          <td class="un" axis="------|4|23|Sets bit 3 of the memory location pointed to by ix plus *.">set 3,(ix+*),a</td>
        </tr>
        <tr>
          <th>E</th>
          <td class="un" axis="------|4|23|Sets bit 4 of the memory location pointed to by ix plus *.">set 4,(ix+*),b</td>
          <td class="un" axis="------|4|23|Sets bit 4 of the memory location pointed to by ix plus *.">set 4,(ix+*),c</td>
          <td class="un" axis="------|4|23|Sets bit 4 of the memory location pointed to by ix plus *.">set 4,(ix+*),d</td>
          <td class="un" axis="------|4|23|Sets bit 4 of the memory location pointed to by ix plus *.">set 4,(ix+*),e</td>
          <td class="un" axis="------|4|23|Sets bit 4 of the memory location pointed to by ix plus *.">set 4,(ix+*),h</td>
          <td class="un" axis="------|4|23|Sets bit 4 of the memory location pointed to by ix plus *.">set 4,(ix+*),l</td>
          <td axis="------|4|23|Sets bit 4 of the memory location pointed to by ix plus *.">set 4,(ix+*)</td>
          <td class="un" axis="------|4|23|Sets bit 4 of the memory location pointed to by ix plus *.">set 4,(ix+*),a</td>
          <td class="un" axis="------|4|23|Sets bit 5 of the memory location pointed to by ix plus *.">set 5,(ix+*),b</td>
          <td class="un" axis="------|4|23|Sets bit 5 of the memory location pointed to by ix plus *.">set 5,(ix+*),c</td>
          <td class="un" axis="------|4|23|Sets bit 5 of the memory location pointed to by ix plus *.">set 5,(ix+*),d</td>
          <td class="un" axis="------|4|23|Sets bit 5 of the memory location pointed to by ix plus *.">set 5,(ix+*),e</td>
          <td class="un" axis="------|4|23|Sets bit 5 of the memory location pointed to by ix plus *.">set 5,(ix+*),h</td>
          <td class="un" axis="------|4|23|Sets bit 5 of the memory location pointed to by ix plus *.">set 5,(ix+*),l</td>
          <td axis="------|4|23|Sets bit 5 of the memory location pointed to by ix plus *.">set 5,(ix+*)</td>
          <td class="un" axis="------|4|23|Sets bit 5 of the memory location pointed to by ix plus *.">set 5,(ix+*),a</td>
        </tr>
        <tr>
          <th>F</th>
          <td class="un" axis="------|4|23|Sets bit 6 of the memory location pointed to by ix plus *.">set 6,(ix+*),b</td>
          <td class="un" axis="------|4|23|Sets bit 6 of the memory location pointed to by ix plus *.">set 6,(ix+*),c</td>
          <td class="un" axis="------|4|23|Sets bit 6 of the memory location pointed to by ix plus *.">set 6,(ix+*),d</td>
          <td class="un" axis="------|4|23|Sets bit 6 of the memory location pointed to by ix plus *.">set 6,(ix+*),e</td>
          <td class="un" axis="------|4|23|Sets bit 6 of the memory location pointed to by ix plus *.">set 6,(ix+*),h</td>
          <td class="un" axis="------|4|23|Sets bit 6 of the memory location pointed to by ix plus *.">set 6,(ix+*),l</td>
          <td axis="------|4|23|Sets bit 6 of the memory location pointed to by ix plus *.">set 6,(ix+*)</td>
          <td class="un" axis="------|4|23|Sets bit 6 of the memory location pointed to by ix plus *.">set 6,(ix+*),a</td>
          <td class="un" axis="------|4|23|Sets bit 7 of the memory location pointed to by ix plus *.">set 7,(ix+*),b</td>
          <td class="un" axis="------|4|23|Sets bit 7 of the memory location pointed to by ix plus *.">set 7,(ix+*),c</td>
          <td class="un" axis="------|4|23|Sets bit 7 of the memory location pointed to by ix plus *.">set 7,(ix+*),d</td>
          <td class="un" axis="------|4|23|Sets bit 7 of the memory location pointed to by ix plus *.">set 7,(ix+*),e</td>
          <td class="un" axis="------|4|23|Sets bit 7 of the memory location pointed to by ix plus *.">set 7,(ix+*),h</td>
          <td class="un" axis="------|4|23|Sets bit 7 of the memory location pointed to by ix plus *.">set 7,(ix+*),l</td>
          <td axis="------|4|23|Sets bit 7 of the memory location pointed to by ix plus *.">set 7,(ix+*)</td>
          <td class="un" axis="------|4|23|Sets bit 7 of the memory location pointed to by ix plus *.">set 7,(ix+*),a</td>
        </tr>
      </table>
      <h3 id="table6">IY instructions (FD)</h3>
      <table title="FD">
        <tr>
          <td></td>
          <th>0</th>
          <th>1</th>
          <th>2</th>
          <th>3</th>
          <th>4</th>
          <th>5</th>
          <th>6</th>
          <th>7</th>
          <th>8</th>
          <th>9</th>
          <th>A</th>
          <th>B</th>
          <th>C</th>
          <th>D</th>
          <th>E</th>
          <th>F</th>
        </tr>
        <tr>
          <th>0</th>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td axis="++-+--|2|15|The value of bc is added to iy.">add iy,bc</td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <th>1</th>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td axis="++-+--|2|15|The value of de is added to iy.">add iy,de</td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <th>2</th>
          <td></td>
          <td axis="------|4|14|Loads ** into register iy.">ld iy,**</td>
          <td axis="------|4|20|Stores iy into the memory location pointed to by **.">ld (**),iy</td>
          <td axis="------|2|10|Adds one to iy.">inc iy</td>
          <td class="un" axis="-+V+++|2|8|Adds one to iyh.">inc iyh</td>
          <td class="un" axis="-+V+++|2|8|Subtracts one from iyh.">dec iyh</td>
          <td class="un" axis="------|3|11|Loads * into iyh.">ld iyh,*</td>
          <td></td>
          <td></td>
          <td axis="++-+--|2|15|The value of ix is added to iy.">add iy,iy</td>
          <td axis="------|4|20|Loads the value pointed to by ** into iy.">ld iy,(**)</td>
          <td axis="------|2|10|Subtracts one from iy.">dec iy</td>
          <td class="un" axis="-+V+++|2|8|Adds one to iyl.">inc iyl</td>
          <td class="un" axis="-+V+++|2|8|Subtracts one from iyl.">dec iyl</td>
          <td class="un" axis="------|3|11|Loads * into iyl.">ld iyl,*</td>
          <td></td>
        </tr>
        <tr>
          <th>3</th>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td axis="-+V+++|3|23|Adds one to the memory location pointed to by iy plus *.">inc (iy+*)</td>
          <td axis="-+V+++|3|23|Subtracts one from the memory location pointed to by iy plus *.">dec (iy+*)</td>
          <td axis="------|4|19|Stores * to the memory location pointed to by iy plus *.">ld (iy+*),*</td>
          <td></td>
          <td></td>
          <td axis="++-+--|2|15|The value of sp is added to iy.">add iy,sp</td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <th>4</th>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td class="un" axis="------|2|8|The contents of iyh are loaded into b.">ld b,iyh</td>
          <td class="un" axis="------|2|8|The contents of iyl are loaded into b.">ld b,iyl</td>
          <td axis="------|3|19|Loads the value pointed to by iy plus * into b.">ld b,(iy+*)</td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td class="un" axis="------|2|8|The contents of iyh are loaded into c.">ld c,iyh</td>
          <td class="un" axis="------|2|8|The contents of iyl are loaded into c.">ld c,iyl</td>
          <td axis="------|3|19|Loads the value pointed to by iy plus * into c.">ld c,(iy+*)</td>
          <td></td>
        </tr>
        <tr>
          <th>5</th>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td class="un" axis="------|2|8|The contents of iyh are loaded into d.">ld d,iyh</td>
          <td class="un" axis="------|2|8|The contents of iyl are loaded into d.">ld d,iyl</td>
          <td axis="------|3|19|Loads the value pointed to by iy plus * into d.">ld d,(iy+*)</td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td class="un" axis="------|2|8|The contents of iyh are loaded into e.">ld e,iyh</td>
          <td class="un" axis="------|2|8|The contents of iyl are loaded into e.">ld e,iyl</td>
          <td axis="------|3|19|Loads the value pointed to by iy plus * into e.">ld e,(iy+*)</td>
          <td></td>
        </tr>
        <tr>
          <th>6</th>
          <td class="un" axis="------|2|8|The contents of b are loaded into iyh.">ld iyh,b</td>
          <td class="un" axis="------|2|8|The contents of c are loaded into iyh.">ld iyh,c</td>
          <td class="un" axis="------|2|8|The contents of d are loaded into iyh.">ld iyh,d</td>
          <td class="un" axis="------|2|8|The contents of e are loaded into iyh.">ld iyh,e</td>
          <td class="un" axis="------|2|8|The contents of iyh are loaded into iyh.">ld iyh,iyh</td>
          <td class="un" axis="------|2|8|The contents of iyl are loaded into iyh.">ld iyh,iyl</td>
          <td axis="------|3|19|Loads the value pointed to by iy plus * into h.">ld h,(iy+*)</td>
          <td class="un" axis="------|2|8|The contents of a are loaded into iyh.">ld iyh,a</td>
          <td class="un" axis="------|2|8|The contents of b are loaded into iyl.">ld iyl,b</td>
          <td class="un" axis="------|2|8|The contents of c are loaded into iyl.">ld iyl,c</td>
          <td class="un" axis="------|2|8|The contents of d are loaded into iyl.">ld iyl,d</td>
          <td class="un" axis="------|2|8|The contents of e are loaded into iyl.">ld iyl,e</td>
          <td class="un" axis="------|2|8|The contents of iyh are loaded into iyl.">ld iyl,iyh</td>
          <td class="un" axis="------|2|8|The contents of iyl are loaded into iyl.">ld iyl,iyl</td>
          <td axis="------|3|19|Loads the value pointed to by iy plus * into l.">ld l,(iy+*)</td>
          <td class="un" axis="------|2|8|The contents of a are loaded into iyl.">ld iyl,a</td>
        </tr>
        <tr>
          <th>7</th>
          <td axis="------|3|19|Stores b to the memory location pointed to by iy plus *.">ld (iy+*),b</td>
          <td axis="------|3|19|Stores c to the memory location pointed to by iy plus *.">ld (iy+*),c</td>
          <td axis="------|3|19|Stores d to the memory location pointed to by iy plus *.">ld (iy+*),d</td>
          <td axis="------|3|19|Stores e to the memory location pointed to by iy plus *.">ld (iy+*),e</td>
          <td axis="------|3|19|Stores h to the memory location pointed to by iy plus *.">ld (iy+*),h</td>
          <td axis="------|3|19|Stores l to the memory location pointed to by iy plus *.">ld (iy+*),l</td>
          <td></td>
          <td axis="------|3|19|Stores a to the memory location pointed to by iy plus *.">ld (iy+*),a</td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td class="un" axis="------|2|8|The contents of iyh are loaded into a.">ld a,iyh</td>
          <td class="un" axis="------|2|8|The contents of iyl are loaded into a.">ld a,iyl</td>
          <td axis="------|3|19|Loads the value pointed to by iy plus * into a.">ld a,(iy+*)</td>
          <td></td>
        </tr>
        <tr>
          <th>8</th>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td class="un" axis="++V+++|2|8|Adds iyh to a.">add a,iyh</td>
          <td class="un" axis="++V+++|2|8|Adds iyl to a.">add a,iyl</td>
          <td axis="++V+++|3|19|Adds the value pointed to by iy plus * to a.">add a,(iy+*)</td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td class="un" axis="++V+++|2|8|Adds iyh and the carry flag to a.">adc a,iyh</td>
          <td class="un" axis="++V+++|2|8|Adds iyl and the carry flag to a.">adc a,iyl</td>
          <td axis="++V+++|3|19|Adds the value pointed to by iy plus * and the carry flag to a.">adc a,(iy+*)</td>
          <td></td>
        </tr>
        <tr>
          <th>9</th>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td class="un" axis="++V+++|2|8|Subtracts iyh from a.">sub iyh</td>
          <td class="un" axis="++V+++|2|8|Subtracts iyl from a.">sub iyl</td>
          <td axis="++V+++|3|19|Subtracts the value pointed to by iy plus * from a.">sub (iy+*)</td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td class="un" axis="++V+++|2|8|Subtracts iyh and the carry flag from a.">sbc a,iyh</td>
          <td class="un" axis="++V+++|2|8|Subtracts iyl and the carry flag from a.">sbc a,iyl</td>
          <td axis="++V+++|3|19|Subtracts the value pointed to by iy plus * and the carry flag from a.">sbc a,(iy+*)</td>
          <td></td>
        </tr>
        <tr>
          <th>A</th>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td class="un" axis="00P1++|2|8|Bitwise AND on a with iyh.">and iyh</td>
          <td class="un" axis="00P1++|2|8|Bitwise AND on a with iyl.">and iyl</td>
          <td axis="00P1++|3|19|Bitwise AND on a with the value pointed to by iy plus *.">and (iy+*)</td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td class="un" axis="00P0++|2|8|Bitwise XOR on a with iyh.">xor iyh</td>
          <td class="un" axis="00P0++|2|8|Bitwise XOR on a with iyl.">xor iyl</td>
          <td axis="00P0++|3|19|Bitwise XOR on a with the value pointed to by iy plus *.">xor (iy+*)</td>
          <td></td>
        </tr>
        <tr>
          <th>B</th>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td class="un" axis="00P0++|2|8|Bitwise OR on a with iyh.">or iyh</td>
          <td class="un" axis="00P0++|2|8|Bitwise OR on a with iyl.">or iyl</td>
          <td axis="00P0++|3|19|Bitwise OR on a with the value pointed to by iy plus *.">or (iy+*)</td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td class="un" axis="++V+++|2|8|Subtracts iyh from a and affects flags according to the result. a is not modified.">cp iyh</td>
          <td class="un" axis="++V+++|2|8|Subtracts iyl from a and affects flags according to the result. a is not modified.">cp iyl</td>
          <td axis="++V+++|3|19|Subtracts the value pointed to by iy plus * from a and affects flags according to the result. a is not modified.">cp (iy+*)</td>
          <td></td>
        </tr>
        <tr>
          <th>C</th>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td class="ln">
            <a href="#table7">IY BITS</a>
          </td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <th>D</th>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <th>E</th>
          <td></td>
          <td axis="------|2|14|The memory location pointed to by sp is stored into iyl and sp is incremented. The memory location pointed to by sp is stored into iyh and sp is incremented again.">pop iy</td>
          <td></td>
          <td axis="------|2|23|Exchanges (sp) with the iyl, and (sp+1) with the iyh.">ex (sp),iy</td>
          <td></td>
          <td axis="------|2|15|sp is decremented and iyh is stored into the memory location pointed to by sp. sp is decremented again and iyl is stored into the memory location pointed to by sp.">push iy</td>
          <td></td>
          <td></td>
          <td></td>
          <td axis="------|2|8|Loads the value of iy into pc.">jp (iy)</td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <th>F</th>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td axis="------|2|10|Loads the value of iy into sp.">ld sp,iy</td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
      </table>
      <h3 id="table7">IY bit instructions (FDCB)</h3>
      <table title="FDCB**">
        <tr>
          <td></td>
          <th>0</th>
          <th>1</th>
          <th>2</th>
          <th>3</th>
          <th>4</th>
          <th>5</th>
          <th>6</th>
          <th>7</th>
          <th>8</th>
          <th>9</th>
          <th>A</th>
          <th>B</th>
          <th>C</th>
          <th>D</th>
          <th>E</th>
          <th>F</th>
        </tr>
        <tr>
          <th>0</th>
          <td class="un" axis="+0P0++|4|23|The contents of the memory location pointed to by iy plus * are rotated left one bit position. The contents of bit 7 are copied to the carry flag and bit 0. The result is then stored in b.">rlc (iy+*),b</td>
          <td class="un" axis="+0P0++|4|23|The contents of the memory location pointed to by iy plus * are rotated left one bit position. The contents of bit 7 are copied to the carry flag and bit 0. The result is then stored in c.">rlc (iy+*),c</td>
          <td class="un" axis="+0P0++|4|23|The contents of the memory location pointed to by iy plus * are rotated left one bit position. The contents of bit 7 are copied to the carry flag and bit 0. The result is then stored in d.">rlc (iy+*),d</td>
          <td class="un" axis="+0P0++|4|23|The contents of the memory location pointed to by iy plus * are rotated left one bit position. The contents of bit 7 are copied to the carry flag and bit 0. The result is then stored in e.">rlc (iy+*),e</td>
          <td class="un" axis="+0P0++|4|23|The contents of the memory location pointed to by iy plus * are rotated left one bit position. The contents of bit 7 are copied to the carry flag and bit 0. The result is then stored in h.">rlc (iy+*),h</td>
          <td class="un" axis="+0P0++|4|23|The contents of the memory location pointed to by iy plus * are rotated left one bit position. The contents of bit 7 are copied to the carry flag and bit 0. The result is then stored in l.">rlc (iy+*),l</td>
          <td axis="+0P0++|4|23|The contents of the memory location pointed to by iy plus * are rotated left one bit position. The contents of bit 7 are copied to the carry flag and bit 0.">rlc (iy+*)</td>
          <td class="un" axis="+0P0++|4|23|The contents of the memory location pointed to by iy plus * are rotated left one bit position. The contents of bit 7 are copied to the carry flag and bit 0. The result is then stored in a.">rlc (iy+*),a</td>
          <td class="un" axis="+0P0++|4|23|The contents of the memory location pointed to by iy plus * are rotated right one bit position. The contents of bit 0 are copied to the carry flag and bit 7. The result is then stored in b.">rrc (iy+*),b</td>
          <td class="un" axis="+0P0++|4|23|The contents of the memory location pointed to by iy plus * are rotated right one bit position. The contents of bit 0 are copied to the carry flag and bit 7. The result is then stored in c.">rrc (iy+*),c</td>
          <td class="un" axis="+0P0++|4|23|The contents of the memory location pointed to by iy plus * are rotated right one bit position. The contents of bit 0 are copied to the carry flag and bit 7. The result is then stored in d.">rrc (iy+*),d</td>
          <td class="un" axis="+0P0++|4|23|The contents of the memory location pointed to by iy plus * are rotated right one bit position. The contents of bit 0 are copied to the carry flag and bit 7. The result is then stored in e.">rrc (iy+*),e</td>
          <td class="un" axis="+0P0++|4|23|The contents of the memory location pointed to by iy plus * are rotated right one bit position. The contents of bit 0 are copied to the carry flag and bit 7. The result is then stored in h.">rrc (iy+*),h</td>
          <td class="un" axis="+0P0++|4|23|The contents of the memory location pointed to by iy plus * are rotated right one bit position. The contents of bit 0 are copied to the carry flag and bit 7. The result is then stored in l.">rrc (iy+*),l</td>
          <td axis="+0P0++|4|23|The contents of the memory location pointed to by iy plus * are rotated right one bit position. The contents of bit 0 are copied to the carry flag and bit 7.">rrc (iy+*)</td>
          <td class="un" axis="+0P0++|4|23|The contents of the memory location pointed to by iy plus * are rotated right one bit position. The contents of bit 0 are copied to the carry flag and bit 7. The result is then stored in a.">rrc (iy+*),a</td>
        </tr>
        <tr>
          <th>1</th>
          <td class="un" axis="+0P0++|4|23|The contents of the memory location pointed to by iy plus * are rotated left one bit position. The contents of bit 7 are copied to the carry flag and the previous contents of the carry flag are copied to bit 0. The result is then stored in b.">rl (iy+*),b</td>
          <td class="un" axis="+0P0++|4|23|The contents of the memory location pointed to by iy plus * are rotated left one bit position. The contents of bit 7 are copied to the carry flag and the previous contents of the carry flag are copied to bit 0. The result is then stored in c.">rl (iy+*),c</td>
          <td class="un" axis="+0P0++|4|23|The contents of the memory location pointed to by iy plus * are rotated left one bit position. The contents of bit 7 are copied to the carry flag and the previous contents of the carry flag are copied to bit 0. The result is then stored in d.">rl (iy+*),d</td>
          <td class="un" axis="+0P0++|4|23|The contents of the memory location pointed to by iy plus * are rotated left one bit position. The contents of bit 7 are copied to the carry flag and the previous contents of the carry flag are copied to bit 0. The result is then stored in e.">rl (iy+*),e</td>
          <td class="un" axis="+0P0++|4|23|The contents of the memory location pointed to by iy plus * are rotated left one bit position. The contents of bit 7 are copied to the carry flag and the previous contents of the carry flag are copied to bit 0. The result is then stored in h.">rl (iy+*),h</td>
          <td class="un" axis="+0P0++|4|23|The contents of the memory location pointed to by iy plus * are rotated left one bit position. The contents of bit 7 are copied to the carry flag and the previous contents of the carry flag are copied to bit 0. The result is then stored in l.">rl (iy+*),l</td>
          <td axis="+0P0++|4|23|The contents of the memory location pointed to by iy plus * are rotated left one bit position. The contents of bit 7 are copied to the carry flag and the previous contents of the carry flag are copied to bit 0.">rl (iy+*)</td>
          <td class="un" axis="+0P0++|4|23|The contents of the memory location pointed to by iy plus * are rotated left one bit position. The contents of bit 7 are copied to the carry flag and the previous contents of the carry flag are copied to bit 0. The result is then stored in a.">rl (iy+*),a</td>
          <td class="un" axis="+0P0++|4|23|The contents of the memory location pointed to by iy plus * are rotated right one bit position. The contents of bit 0 are copied to the carry flag and the previous contents of the carry flag are copied to bit 7. The result is then stored in b.">rr (iy+*),b</td>
          <td class="un" axis="+0P0++|4|23|The contents of the memory location pointed to by iy plus * are rotated right one bit position. The contents of bit 0 are copied to the carry flag and the previous contents of the carry flag are copied to bit 7. The result is then stored in c.">rr (iy+*),c</td>
          <td class="un" axis="+0P0++|4|23|The contents of the memory location pointed to by iy plus * are rotated right one bit position. The contents of bit 0 are copied to the carry flag and the previous contents of the carry flag are copied to bit 7. The result is then stored in d.">rr (iy+*),d</td>
          <td class="un" axis="+0P0++|4|23|The contents of the memory location pointed to by iy plus * are rotated right one bit position. The contents of bit 0 are copied to the carry flag and the previous contents of the carry flag are copied to bit 7. The result is then stored in e.">rr (iy+*),e</td>
          <td class="un" axis="+0P0++|4|23|The contents of the memory location pointed to by iy plus * are rotated right one bit position. The contents of bit 0 are copied to the carry flag and the previous contents of the carry flag are copied to bit 7. The result is then stored in h.">rr (iy+*),h</td>
          <td class="un" axis="+0P0++|4|23|The contents of the memory location pointed to by iy plus * are rotated right one bit position. The contents of bit 0 are copied to the carry flag and the previous contents of the carry flag are copied to bit 7. The result is then stored in l.">rr (iy+*),l</td>
          <td axis="+0P0++|4|23|The contents of the memory location pointed to by iy plus * are rotated right one bit position. The contents of bit 0 are copied to the carry flag and the previous contents of the carry flag are copied to bit 7.">rr (iy+*)</td>
          <td class="un" axis="+0P0++|4|23|The contents of the memory location pointed to by iy plus * are rotated right one bit position. The contents of bit 0 are copied to the carry flag and the previous contents of the carry flag are copied to bit 7. The result is then stored in a.">rr (iy+*),a</td>
        </tr>
        <tr>
          <th>2</th>
          <td class="un" axis="+0P0++|4|23|The contents of the memory location pointed to by iy plus * are shifted left one bit position. The contents of bit 7 are copied to the carry flag and a zero is put into bit 0. The result is then stored in b.">sla (iy+*),b</td>
          <td class="un" axis="+0P0++|4|23|The contents of the memory location pointed to by iy plus * are shifted left one bit position. The contents of bit 7 are copied to the carry flag and a zero is put into bit 0. The result is then stored in c.">sla (iy+*),c</td>
          <td class="un" axis="+0P0++|4|23|The contents of the memory location pointed to by iy plus * are shifted left one bit position. The contents of bit 7 are copied to the carry flag and a zero is put into bit 0. The result is then stored in d.">sla (iy+*),d</td>
          <td class="un" axis="+0P0++|4|23|The contents of the memory location pointed to by iy plus * are shifted left one bit position. The contents of bit 7 are copied to the carry flag and a zero is put into bit 0. The result is then stored in e.">sla (iy+*),e</td>
          <td class="un" axis="+0P0++|4|23|The contents of the memory location pointed to by iy plus * are shifted left one bit position. The contents of bit 7 are copied to the carry flag and a zero is put into bit 0. The result is then stored in h.">sla (iy+*),h</td>
          <td class="un" axis="+0P0++|4|23|The contents of the memory location pointed to by iy plus * are shifted left one bit position. The contents of bit 7 are copied to the carry flag and a zero is put into bit 0. The result is then stored in l.">sla (iy+*),l</td>
          <td axis="+0P0++|4|23|The contents of the memory location pointed to by iy plus * are shifted left one bit position. The contents of bit 7 are copied to the carry flag and a zero is put into bit 0.">sla (iy+*)</td>
          <td class="un" axis="+0P0++|4|23|The contents of the memory location pointed to by iy plus * are shifted left one bit position. The contents of bit 7 are copied to the carry flag and a zero is put into bit 0. The result is then stored in a.">sla (iy+*),a</td>
          <td class="un" axis="+0P0++|4|23|The contents of the memory location pointed to by iy plus * are shifted right one bit position. The contents of bit 0 are copied to the carry flag and the previous contents of bit 7 are unchanged. The result is then stored in b.">sra (iy+*),b</td>
          <td class="un" axis="+0P0++|4|23|The contents of the memory location pointed to by iy plus * are shifted right one bit position. The contents of bit 0 are copied to the carry flag and the previous contents of bit 7 are unchanged. The result is then stored in c.">sra (iy+*),c</td>
          <td class="un" axis="+0P0++|4|23|The contents of the memory location pointed to by iy plus * are shifted right one bit position. The contents of bit 0 are copied to the carry flag and the previous contents of bit 7 are unchanged. The result is then stored in d.">sra (iy+*),d</td>
          <td class="un" axis="+0P0++|4|23|The contents of the memory location pointed to by iy plus * are shifted right one bit position. The contents of bit 0 are copied to the carry flag and the previous contents of bit 7 are unchanged. The result is then stored in e.">sra (iy+*),e</td>
          <td class="un" axis="+0P0++|4|23|The contents of the memory location pointed to by iy plus * are shifted right one bit position. The contents of bit 0 are copied to the carry flag and the previous contents of bit 7 are unchanged. The result is then stored in h.">sra (iy+*),h</td>
          <td class="un" axis="+0P0++|4|23|The contents of the memory location pointed to by iy plus * are shifted right one bit position. The contents of bit 0 are copied to the carry flag and the previous contents of bit 7 are unchanged. The result is then stored in l.">sra (iy+*),l</td>
          <td axis="+0P0++|4|23|The contents of the memory location pointed to by iy plus * are shifted right one bit position. The contents of bit 0 are copied to the carry flag and the previous contents of bit 7 are unchanged.">sra (iy+*)</td>
          <td class="un" axis="+0P0++|4|23|The contents of the memory location pointed to by iy plus * are shifted right one bit position. The contents of bit 0 are copied to the carry flag and the previous contents of bit 7 are unchanged. The result is then stored in a.">sra (iy+*),a</td>
        </tr>
        <tr>
          <th>3</th>
          <td class="un" axis="+0P0++|4|23|The contents of the memory location pointed to by iy plus * are shifted left one bit position. The contents of bit 7 are put into the carry flag and a one is put into bit 0. The result is then stored in b.">sll (iy+*),b</td>
          <td class="un" axis="+0P0++|4|23|The contents of the memory location pointed to by iy plus * are shifted left one bit position. The contents of bit 7 are put into the carry flag and a one is put into bit 0. The result is then stored in c.">sll (iy+*),c</td>
          <td class="un" axis="+0P0++|4|23|The contents of the memory location pointed to by iy plus * are shifted left one bit position. The contents of bit 7 are put into the carry flag and a one is put into bit 0. The result is then stored in d.">sll (iy+*),d</td>
          <td class="un" axis="+0P0++|4|23|The contents of the memory location pointed to by iy plus * are shifted left one bit position. The contents of bit 7 are put into the carry flag and a one is put into bit 0. The result is then stored in e.">sll (iy+*),e</td>
          <td class="un" axis="+0P0++|4|23|The contents of the memory location pointed to by iy plus * are shifted left one bit position. The contents of bit 7 are put into the carry flag and a one is put into bit 0. The result is then stored in h.">sll (iy+*),h</td>
          <td class="un" axis="+0P0++|4|23|The contents of the memory location pointed to by iy plus * are shifted left one bit position. The contents of bit 7 are put into the carry flag and a one is put into bit 0. The result is then stored in l.">sll (iy+*),l</td>
          <td class="un" axis="+0P0++|4|23|The contents of the memory location pointed to by iy plus * are shifted left one bit position. The contents of bit 7 are put into the carry flag and a one is put into bit 0.">sll (iy+*)</td>
          <td class="un" axis="+0P0++|4|23|The contents of the memory location pointed to by iy plus * are shifted left one bit position. The contents of bit 7 are put into the carry flag and a one is put into bit 0. The result is then stored in a.">sll (iy+*),a</td>
          <td class="un" axis="+0P0++|4|23|The contents of the memory location pointed to by iy plus * are shifted right one bit position. The contents of bit 0 are copied to the carry flag and a zero is put into bit 7. The result is then stored in b.">srl (iy+*),b</td>
          <td class="un" axis="+0P0++|4|23|The contents of the memory location pointed to by iy plus * are shifted right one bit position. The contents of bit 0 are copied to the carry flag and a zero is put into bit 7. The result is then stored in c.">srl (iy+*),c</td>
          <td class="un" axis="+0P0++|4|23|The contents of the memory location pointed to by iy plus * are shifted right one bit position. The contents of bit 0 are copied to the carry flag and a zero is put into bit 7. The result is then stored in d.">srl (iy+*),d</td>
          <td class="un" axis="+0P0++|4|23|The contents of the memory location pointed to by iy plus * are shifted right one bit position. The contents of bit 0 are copied to the carry flag and a zero is put into bit 7. The result is then stored in e.">srl (iy+*),e</td>
          <td class="un" axis="+0P0++|4|23|The contents of the memory location pointed to by iy plus * are shifted right one bit position. The contents of bit 0 are copied to the carry flag and a zero is put into bit 7. The result is then stored in h.">srl (iy+*),h</td>
          <td class="un" axis="+0P0++|4|23|The contents of the memory location pointed to by iy plus * are shifted right one bit position. The contents of bit 0 are copied to the carry flag and a zero is put into bit 7. The result is then stored in l.">srl (iy+*),l</td>
          <td axis="+0P0++|4|23|The contents of the memory location pointed to by iy plus * are shifted right one bit position. The contents of bit 0 are copied to the carry flag and a zero is put into bit 7.">srl (iy+*)</td>
          <td class="un" axis="+0P0++|4|23|The contents of the memory location pointed to by iy plus * are shifted right one bit position. The contents of bit 0 are copied to the carry flag and a zero is put into bit 7. The result is then stored in a.">srl (iy+*),a</td>
        </tr>
        <tr>
          <th>4</th>
          <td class="un" axis="-0 1+ |4|20|Tests bit 0 of the memory location pointed to by iy plus *.">bit 0,(iy+*)</td>
          <td class="un" axis="-0 1+ |4|20|Tests bit 0 of the memory location pointed to by iy plus *.">bit 0,(iy+*)</td>
          <td class="un" axis="-0 1+ |4|20|Tests bit 0 of the memory location pointed to by iy plus *.">bit 0,(iy+*)</td>
          <td class="un" axis="-0 1+ |4|20|Tests bit 0 of the memory location pointed to by iy plus *.">bit 0,(iy+*)</td>
          <td class="un" axis="-0 1+ |4|20|Tests bit 0 of the memory location pointed to by iy plus *.">bit 0,(iy+*)</td>
          <td class="un" axis="-0 1+ |4|20|Tests bit 0 of the memory location pointed to by iy plus *.">bit 0,(iy+*)</td>
          <td axis="-0 1+ |4|20|Tests bit 0 of the memory location pointed to by iy plus *.">bit 0,(iy+*)</td>
          <td class="un" axis="-0 1+ |4|20|Tests bit 0 of the memory location pointed to by iy plus *.">bit 0,(iy+*)</td>
          <td class="un" axis="-0 1+ |4|20|Tests bit 1 of the memory location pointed to by iy plus *.">bit 1,(iy+*)</td>
          <td class="un" axis="-0 1+ |4|20|Tests bit 1 of the memory location pointed to by iy plus *.">bit 1,(iy+*)</td>
          <td class="un" axis="-0 1+ |4|20|Tests bit 1 of the memory location pointed to by iy plus *.">bit 1,(iy+*)</td>
          <td class="un" axis="-0 1+ |4|20|Tests bit 1 of the memory location pointed to by iy plus *.">bit 1,(iy+*)</td>
          <td class="un" axis="-0 1+ |4|20|Tests bit 1 of the memory location pointed to by iy plus *.">bit 1,(iy+*)</td>
          <td class="un" axis="-0 1+ |4|20|Tests bit 1 of the memory location pointed to by iy plus *.">bit 1,(iy+*)</td>
          <td axis="-0 1+ |4|20|Tests bit 1 of the memory location pointed to by iy plus *.">bit 1,(iy+*)</td>
          <td class="un" axis="-0 1+ |4|20|Tests bit 1 of the memory location pointed to by iy plus *.">bit 1,(iy+*)</td>
        </tr>
        <tr>
          <th>5</th>
          <td class="un" axis="-0 1+ |4|20|Tests bit 2 of the memory location pointed to by iy plus *.">bit 2,(iy+*)</td>
          <td class="un" axis="-0 1+ |4|20|Tests bit 2 of the memory location pointed to by iy plus *.">bit 2,(iy+*)</td>
          <td class="un" axis="-0 1+ |4|20|Tests bit 2 of the memory location pointed to by iy plus *.">bit 2,(iy+*)</td>
          <td class="un" axis="-0 1+ |4|20|Tests bit 2 of the memory location pointed to by iy plus *.">bit 2,(iy+*)</td>
          <td class="un" axis="-0 1+ |4|20|Tests bit 2 of the memory location pointed to by iy plus *.">bit 2,(iy+*)</td>
          <td class="un" axis="-0 1+ |4|20|Tests bit 2 of the memory location pointed to by iy plus *.">bit 2,(iy+*)</td>
          <td axis="-0 1+ |4|20|Tests bit 2 of the memory location pointed to by iy plus *.">bit 2,(iy+*)</td>
          <td class="un" axis="-0 1+ |4|20|Tests bit 2 of the memory location pointed to by iy plus *.">bit 2,(iy+*)</td>
          <td class="un" axis="-0 1+ |4|20|Tests bit 3 of the memory location pointed to by iy plus *.">bit 3,(iy+*)</td>
          <td class="un" axis="-0 1+ |4|20|Tests bit 3 of the memory location pointed to by iy plus *.">bit 3,(iy+*)</td>
          <td class="un" axis="-0 1+ |4|20|Tests bit 3 of the memory location pointed to by iy plus *.">bit 3,(iy+*)</td>
          <td class="un" axis="-0 1+ |4|20|Tests bit 3 of the memory location pointed to by iy plus *.">bit 3,(iy+*)</td>
          <td class="un" axis="-0 1+ |4|20|Tests bit 3 of the memory location pointed to by iy plus *.">bit 3,(iy+*)</td>
          <td class="un" axis="-0 1+ |4|20|Tests bit 3 of the memory location pointed to by iy plus *.">bit 3,(iy+*)</td>
          <td axis="-0 1+ |4|20|Tests bit 3 of the memory location pointed to by iy plus *.">bit 3,(iy+*)</td>
          <td class="un" axis="-0 1+ |4|20|Tests bit 3 of the memory location pointed to by iy plus *.">bit 3,(iy+*)</td>
        </tr>
        <tr>
          <th>6</th>
          <td class="un" axis="-0 1+ |4|20|Tests bit 4 of the memory location pointed to by iy plus *.">bit 4,(iy+*)</td>
          <td class="un" axis="-0 1+ |4|20|Tests bit 4 of the memory location pointed to by iy plus *.">bit 4,(iy+*)</td>
          <td class="un" axis="-0 1+ |4|20|Tests bit 4 of the memory location pointed to by iy plus *.">bit 4,(iy+*)</td>
          <td class="un" axis="-0 1+ |4|20|Tests bit 4 of the memory location pointed to by iy plus *.">bit 4,(iy+*)</td>
          <td class="un" axis="-0 1+ |4|20|Tests bit 4 of the memory location pointed to by iy plus *.">bit 4,(iy+*)</td>
          <td class="un" axis="-0 1+ |4|20|Tests bit 4 of the memory location pointed to by iy plus *.">bit 4,(iy+*)</td>
          <td axis="-0 1+ |4|20|Tests bit 4 of the memory location pointed to by iy plus *.">bit 4,(iy+*)</td>
          <td class="un" axis="-0 1+ |4|20|Tests bit 4 of the memory location pointed to by iy plus *.">bit 4,(iy+*)</td>
          <td class="un" axis="-0 1+ |4|20|Tests bit 5 of the memory location pointed to by iy plus *.">bit 5,(iy+*)</td>
          <td class="un" axis="-0 1+ |4|20|Tests bit 5 of the memory location pointed to by iy plus *.">bit 5,(iy+*)</td>
          <td class="un" axis="-0 1+ |4|20|Tests bit 5 of the memory location pointed to by iy plus *.">bit 5,(iy+*)</td>
          <td class="un" axis="-0 1+ |4|20|Tests bit 5 of the memory location pointed to by iy plus *.">bit 5,(iy+*)</td>
          <td class="un" axis="-0 1+ |4|20|Tests bit 5 of the memory location pointed to by iy plus *.">bit 5,(iy+*)</td>
          <td class="un" axis="-0 1+ |4|20|Tests bit 5 of the memory location pointed to by iy plus *.">bit 5,(iy+*)</td>
          <td axis="-0 1+ |4|20|Tests bit 5 of the memory location pointed to by iy plus *.">bit 5,(iy+*)</td>
          <td class="un" axis="-0 1+ |4|20|Tests bit 5 of the memory location pointed to by iy plus *.">bit 5,(iy+*)</td>
        </tr>
        <tr>
          <th>7</th>
          <td class="un" axis="-0 1+ |4|20|Tests bit 6 of the memory location pointed to by iy plus *.">bit 6,(iy+*)</td>
          <td class="un" axis="-0 1+ |4|20|Tests bit 6 of the memory location pointed to by iy plus *.">bit 6,(iy+*)</td>
          <td class="un" axis="-0 1+ |4|20|Tests bit 6 of the memory location pointed to by iy plus *.">bit 6,(iy+*)</td>
          <td class="un" axis="-0 1+ |4|20|Tests bit 6 of the memory location pointed to by iy plus *.">bit 6,(iy+*)</td>
          <td class="un" axis="-0 1+ |4|20|Tests bit 6 of the memory location pointed to by iy plus *.">bit 6,(iy+*)</td>
          <td class="un" axis="-0 1+ |4|20|Tests bit 6 of the memory location pointed to by iy plus *.">bit 6,(iy+*)</td>
          <td axis="-0 1+ |4|20|Tests bit 6 of the memory location pointed to by iy plus *.">bit 6,(iy+*)</td>
          <td class="un" axis="-0 1+ |4|20|Tests bit 6 of the memory location pointed to by iy plus *.">bit 6,(iy+*)</td>
          <td class="un" axis="-0 1+ |4|20|Tests bit 7 of the memory location pointed to by iy plus *.">bit 7,(iy+*)</td>
          <td class="un" axis="-0 1+ |4|20|Tests bit 7 of the memory location pointed to by iy plus *.">bit 7,(iy+*)</td>
          <td class="un" axis="-0 1+ |4|20|Tests bit 7 of the memory location pointed to by iy plus *.">bit 7,(iy+*)</td>
          <td class="un" axis="-0 1+ |4|20|Tests bit 7 of the memory location pointed to by iy plus *.">bit 7,(iy+*)</td>
          <td class="un" axis="-0 1+ |4|20|Tests bit 7 of the memory location pointed to by iy plus *.">bit 7,(iy+*)</td>
          <td class="un" axis="-0 1+ |4|20|Tests bit 7 of the memory location pointed to by iy plus *.">bit 7,(iy+*)</td>
          <td axis="-0 1+ |4|20|Tests bit 7 of the memory location pointed to by iy plus *.">bit 7,(iy+*)</td>
          <td class="un" axis="-0 1+ |4|20|Tests bit 7 of the memory location pointed to by iy plus *.">bit 7,(iy+*)</td>
        </tr>
        <tr>
          <th>8</th>
          <td class="un" axis="------|4|23|Resets bit 0 of the memory location pointed to by iy plus *.">res 0,(iy+*),b</td>
          <td class="un" axis="------|4|23|Resets bit 0 of the memory location pointed to by iy plus *.">res 0,(iy+*),c</td>
          <td class="un" axis="------|4|23|Resets bit 0 of the memory location pointed to by iy plus *.">res 0,(iy+*),d</td>
          <td class="un" axis="------|4|23|Resets bit 0 of the memory location pointed to by iy plus *.">res 0,(iy+*),e</td>
          <td class="un" axis="------|4|23|Resets bit 0 of the memory location pointed to by iy plus *.">res 0,(iy+*),h</td>
          <td class="un" axis="------|4|23|Resets bit 0 of the memory location pointed to by iy plus *.">res 0,(iy+*),l</td>
          <td axis="------|4|23|Resets bit 0 of the memory location pointed to by iy plus *.">res 0,(iy+*)</td>
          <td class="un" axis="------|4|23|Resets bit 0 of the memory location pointed to by iy plus *.">res 0,(iy+*),a</td>
          <td class="un" axis="------|4|23|Resets bit 1 of the memory location pointed to by iy plus *.">res 1,(iy+*),b</td>
          <td class="un" axis="------|4|23|Resets bit 1 of the memory location pointed to by iy plus *.">res 1,(iy+*),c</td>
          <td class="un" axis="------|4|23|Resets bit 1 of the memory location pointed to by iy plus *.">res 1,(iy+*),d</td>
          <td class="un" axis="------|4|23|Resets bit 1 of the memory location pointed to by iy plus *.">res 1,(iy+*),e</td>
          <td class="un" axis="------|4|23|Resets bit 1 of the memory location pointed to by iy plus *.">res 1,(iy+*),h</td>
          <td class="un" axis="------|4|23|Resets bit 1 of the memory location pointed to by iy plus *.">res 1,(iy+*),l</td>
          <td axis="------|4|23|Resets bit 1 of the memory location pointed to by iy plus *.">res 1,(iy+*)</td>
          <td class="un" axis="------|4|23|Resets bit 1 of the memory location pointed to by iy plus *.">res 1,(iy+*),a</td>
        </tr>
        <tr>
          <th>9</th>
          <td class="un" axis="------|4|23|Resets bit 2 of the memory location pointed to by iy plus *.">res 2,(iy+*),b</td>
          <td class="un" axis="------|4|23|Resets bit 2 of the memory location pointed to by iy plus *.">res 2,(iy+*),c</td>
          <td class="un" axis="------|4|23|Resets bit 2 of the memory location pointed to by iy plus *.">res 2,(iy+*),d</td>
          <td class="un" axis="------|4|23|Resets bit 2 of the memory location pointed to by iy plus *.">res 2,(iy+*),e</td>
          <td class="un" axis="------|4|23|Resets bit 2 of the memory location pointed to by iy plus *.">res 2,(iy+*),h</td>
          <td class="un" axis="------|4|23|Resets bit 2 of the memory location pointed to by iy plus *.">res 2,(iy+*),l</td>
          <td axis="------|4|23|Resets bit 2 of the memory location pointed to by iy plus *.">res 2,(iy+*)</td>
          <td class="un" axis="------|4|23|Resets bit 2 of the memory location pointed to by iy plus *.">res 2,(iy+*),a</td>
          <td class="un" axis="------|4|23|Resets bit 3 of the memory location pointed to by iy plus *.">res 3,(iy+*),b</td>
          <td class="un" axis="------|4|23|Resets bit 3 of the memory location pointed to by iy plus *.">res 3,(iy+*),c</td>
          <td class="un" axis="------|4|23|Resets bit 3 of the memory location pointed to by iy plus *.">res 3,(iy+*),d</td>
          <td class="un" axis="------|4|23|Resets bit 3 of the memory location pointed to by iy plus *.">res 3,(iy+*),e</td>
          <td class="un" axis="------|4|23|Resets bit 3 of the memory location pointed to by iy plus *.">res 3,(iy+*),h</td>
          <td class="un" axis="------|4|23|Resets bit 3 of the memory location pointed to by iy plus *.">res 3,(iy+*),l</td>
          <td axis="------|4|23|Resets bit 3 of the memory location pointed to by iy plus *.">res 3,(iy+*)</td>
          <td class="un" axis="------|4|23|Resets bit 3 of the memory location pointed to by iy plus *.">res 3,(iy+*),a</td>
        </tr>
        <tr>
          <th>A</th>
          <td class="un" axis="------|4|23|Resets bit 4 of the memory location pointed to by iy plus *.">res 4,(iy+*),b</td>
          <td class="un" axis="------|4|23|Resets bit 4 of the memory location pointed to by iy plus *.">res 4,(iy+*),c</td>
          <td class="un" axis="------|4|23|Resets bit 4 of the memory location pointed to by iy plus *.">res 4,(iy+*),d</td>
          <td class="un" axis="------|4|23|Resets bit 4 of the memory location pointed to by iy plus *.">res 4,(iy+*),e</td>
          <td class="un" axis="------|4|23|Resets bit 4 of the memory location pointed to by iy plus *.">res 4,(iy+*),h</td>
          <td class="un" axis="------|4|23|Resets bit 4 of the memory location pointed to by iy plus *.">res 4,(iy+*),l</td>
          <td axis="------|4|23|Resets bit 4 of the memory location pointed to by iy plus *.">res 4,(iy+*)</td>
          <td class="un" axis="------|4|23|Resets bit 4 of the memory location pointed to by iy plus *.">res 4,(iy+*),a</td>
          <td class="un" axis="------|4|23|Resets bit 5 of the memory location pointed to by iy plus *.">res 5,(iy+*),b</td>
          <td class="un" axis="------|4|23|Resets bit 5 of the memory location pointed to by iy plus *.">res 5,(iy+*),c</td>
          <td class="un" axis="------|4|23|Resets bit 5 of the memory location pointed to by iy plus *.">res 5,(iy+*),d</td>
          <td class="un" axis="------|4|23|Resets bit 5 of the memory location pointed to by iy plus *.">res 5,(iy+*),e</td>
          <td class="un" axis="------|4|23|Resets bit 5 of the memory location pointed to by iy plus *.">res 5,(iy+*),h</td>
          <td class="un" axis="------|4|23|Resets bit 5 of the memory location pointed to by iy plus *.">res 5,(iy+*),l</td>
          <td axis="------|4|23|Resets bit 5 of the memory location pointed to by iy plus *.">res 5,(iy+*)</td>
          <td class="un" axis="------|4|23|Resets bit 5 of the memory location pointed to by iy plus *.">res 5,(iy+*),a</td>
        </tr>
        <tr>
          <th>B</th>
          <td class="un" axis="------|4|23|Resets bit 6 of the memory location pointed to by iy plus *.">res 6,(iy+*),b</td>
          <td class="un" axis="------|4|23|Resets bit 6 of the memory location pointed to by iy plus *.">res 6,(iy+*),c</td>
          <td class="un" axis="------|4|23|Resets bit 6 of the memory location pointed to by iy plus *.">res 6,(iy+*),d</td>
          <td class="un" axis="------|4|23|Resets bit 6 of the memory location pointed to by iy plus *.">res 6,(iy+*),e</td>
          <td class="un" axis="------|4|23|Resets bit 6 of the memory location pointed to by iy plus *.">res 6,(iy+*),h</td>
          <td class="un" axis="------|4|23|Resets bit 6 of the memory location pointed to by iy plus *.">res 6,(iy+*),l</td>
          <td axis="------|4|23|Resets bit 6 of the memory location pointed to by iy plus *.">res 6,(iy+*)</td>
          <td class="un" axis="------|4|23|Resets bit 6 of the memory location pointed to by iy plus *.">res 6,(iy+*),a</td>
          <td class="un" axis="------|4|23|Resets bit 7 of the memory location pointed to by iy plus *.">res 7,(iy+*),b</td>
          <td class="un" axis="------|4|23|Resets bit 7 of the memory location pointed to by iy plus *.">res 7,(iy+*),c</td>
          <td class="un" axis="------|4|23|Resets bit 7 of the memory location pointed to by iy plus *.">res 7,(iy+*),d</td>
          <td class="un" axis="------|4|23|Resets bit 7 of the memory location pointed to by iy plus *.">res 7,(iy+*),e</td>
          <td class="un" axis="------|4|23|Resets bit 7 of the memory location pointed to by iy plus *.">res 7,(iy+*),h</td>
          <td class="un" axis="------|4|23|Resets bit 7 of the memory location pointed to by iy plus *.">res 7,(iy+*),l</td>
          <td axis="------|4|23|Resets bit 7 of the memory location pointed to by iy plus *.">res 7,(iy+*)</td>
          <td class="un" axis="------|4|23|Resets bit 7 of the memory location pointed to by iy plus *.">res 7,(iy+*),a</td>
        </tr>
        <tr>
          <th>C</th>
          <td class="un" axis="------|4|23|Sets bit 0 of the memory location pointed to by iy plus *.">set 0,(iy+*),b</td>
          <td class="un" axis="------|4|23|Sets bit 0 of the memory location pointed to by iy plus *.">set 0,(iy+*),c</td>
          <td class="un" axis="------|4|23|Sets bit 0 of the memory location pointed to by iy plus *.">set 0,(iy+*),d</td>
          <td class="un" axis="------|4|23|Sets bit 0 of the memory location pointed to by iy plus *.">set 0,(iy+*),e</td>
          <td class="un" axis="------|4|23|Sets bit 0 of the memory location pointed to by iy plus *.">set 0,(iy+*),h</td>
          <td class="un" axis="------|4|23|Sets bit 0 of the memory location pointed to by iy plus *.">set 0,(iy+*),l</td>
          <td axis="------|4|23|Sets bit 0 of the memory location pointed to by iy plus *.">set 0,(iy+*)</td>
          <td class="un" axis="------|4|23|Sets bit 0 of the memory location pointed to by iy plus *.">set 0,(iy+*),a</td>
          <td class="un" axis="------|4|23|Sets bit 1 of the memory location pointed to by iy plus *.">set 1,(iy+*),b</td>
          <td class="un" axis="------|4|23|Sets bit 1 of the memory location pointed to by iy plus *.">set 1,(iy+*),c</td>
          <td class="un" axis="------|4|23|Sets bit 1 of the memory location pointed to by iy plus *.">set 1,(iy+*),d</td>
          <td class="un" axis="------|4|23|Sets bit 1 of the memory location pointed to by iy plus *.">set 1,(iy+*),e</td>
          <td class="un" axis="------|4|23|Sets bit 1 of the memory location pointed to by iy plus *.">set 1,(iy+*),h</td>
          <td class="un" axis="------|4|23|Sets bit 1 of the memory location pointed to by iy plus *.">set 1,(iy+*),l</td>
          <td axis="------|4|23|Sets bit 1 of the memory location pointed to by iy plus *.">set 1,(iy+*)</td>
          <td class="un" axis="------|4|23|Sets bit 1 of the memory location pointed to by iy plus *.">set 1,(iy+*),a</td>
        </tr>
        <tr>
          <th>D</th>
          <td class="un" axis="------|4|23|Sets bit 2 of the memory location pointed to by iy plus *.">set 2,(iy+*),b</td>
          <td class="un" axis="------|4|23|Sets bit 2 of the memory location pointed to by iy plus *.">set 2,(iy+*),c</td>
          <td class="un" axis="------|4|23|Sets bit 2 of the memory location pointed to by iy plus *.">set 2,(iy+*),d</td>
          <td class="un" axis="------|4|23|Sets bit 2 of the memory location pointed to by iy plus *.">set 2,(iy+*),e</td>
          <td class="un" axis="------|4|23|Sets bit 2 of the memory location pointed to by iy plus *.">set 2,(iy+*),h</td>
          <td class="un" axis="------|4|23|Sets bit 2 of the memory location pointed to by iy plus *.">set 2,(iy+*),l</td>
          <td axis="------|4|23|Sets bit 2 of the memory location pointed to by iy plus *.">set 2,(iy+*)</td>
          <td class="un" axis="------|4|23|Sets bit 2 of the memory location pointed to by iy plus *.">set 2,(iy+*),a</td>
          <td class="un" axis="------|4|23|Sets bit 3 of the memory location pointed to by iy plus *.">set 3,(iy+*),b</td>
          <td class="un" axis="------|4|23|Sets bit 3 of the memory location pointed to by iy plus *.">set 3,(iy+*),c</td>
          <td class="un" axis="------|4|23|Sets bit 3 of the memory location pointed to by iy plus *.">set 3,(iy+*),d</td>
          <td class="un" axis="------|4|23|Sets bit 3 of the memory location pointed to by iy plus *.">set 3,(iy+*),e</td>
          <td class="un" axis="------|4|23|Sets bit 3 of the memory location pointed to by iy plus *.">set 3,(iy+*),h</td>
          <td class="un" axis="------|4|23|Sets bit 3 of the memory location pointed to by iy plus *.">set 3,(iy+*),l</td>
          <td axis="------|4|23|Sets bit 3 of the memory location pointed to by iy plus *.">set 3,(iy+*)</td>
          <td class="un" axis="------|4|23|Sets bit 3 of the memory location pointed to by iy plus *.">set 3,(iy+*),a</td>
        </tr>
        <tr>
          <th>E</th>
          <td class="un" axis="------|4|23|Sets bit 4 of the memory location pointed to by iy plus *.">set 4,(iy+*),b</td>
          <td class="un" axis="------|4|23|Sets bit 4 of the memory location pointed to by iy plus *.">set 4,(iy+*),c</td>
          <td class="un" axis="------|4|23|Sets bit 4 of the memory location pointed to by iy plus *.">set 4,(iy+*),d</td>
          <td class="un" axis="------|4|23|Sets bit 4 of the memory location pointed to by iy plus *.">set 4,(iy+*),e</td>
          <td class="un" axis="------|4|23|Sets bit 4 of the memory location pointed to by iy plus *.">set 4,(iy+*),h</td>
          <td class="un" axis="------|4|23|Sets bit 4 of the memory location pointed to by iy plus *.">set 4,(iy+*),l</td>
          <td axis="------|4|23|Sets bit 4 of the memory location pointed to by iy plus *.">set 4,(iy+*)</td>
          <td class="un" axis="------|4|23|Sets bit 4 of the memory location pointed to by iy plus *.">set 4,(iy+*),a</td>
          <td class="un" axis="------|4|23|Sets bit 5 of the memory location pointed to by iy plus *.">set 5,(iy+*),b</td>
          <td class="un" axis="------|4|23|Sets bit 5 of the memory location pointed to by iy plus *.">set 5,(iy+*),c</td>
          <td class="un" axis="------|4|23|Sets bit 5 of the memory location pointed to by iy plus *.">set 5,(iy+*),d</td>
          <td class="un" axis="------|4|23|Sets bit 5 of the memory location pointed to by iy plus *.">set 5,(iy+*),e</td>
          <td class="un" axis="------|4|23|Sets bit 5 of the memory location pointed to by iy plus *.">set 5,(iy+*),h</td>
          <td class="un" axis="------|4|23|Sets bit 5 of the memory location pointed to by iy plus *.">set 5,(iy+*),l</td>
          <td axis="------|4|23|Sets bit 5 of the memory location pointed to by iy plus *.">set 5,(iy+*)</td>
          <td class="un" axis="------|4|23|Sets bit 5 of the memory location pointed to by iy plus *.">set 5,(iy+*),a</td>
        </tr>
        <tr>
          <th>F</th>
          <td class="un" axis="------|4|23|Sets bit 6 of the memory location pointed to by iy plus *.">set 6,(iy+*),b</td>
          <td class="un" axis="------|4|23|Sets bit 6 of the memory location pointed to by iy plus *.">set 6,(iy+*),c</td>
          <td class="un" axis="------|4|23|Sets bit 6 of the memory location pointed to by iy plus *.">set 6,(iy+*),d</td>
          <td class="un" axis="------|4|23|Sets bit 6 of the memory location pointed to by iy plus *.">set 6,(iy+*),e</td>
          <td class="un" axis="------|4|23|Sets bit 6 of the memory location pointed to by iy plus *.">set 6,(iy+*),h</td>
          <td class="un" axis="------|4|23|Sets bit 6 of the memory location pointed to by iy plus *.">set 6,(iy+*),l</td>
          <td axis="------|4|23|Sets bit 6 of the memory location pointed to by iy plus *.">set 6,(iy+*)</td>
          <td class="un" axis="------|4|23|Sets bit 6 of the memory location pointed to by iy plus *.">set 6,(iy+*),a</td>
          <td class="un" axis="------|4|23|Sets bit 7 of the memory location pointed to by iy plus *.">set 7,(iy+*),b</td>
          <td class="un" axis="------|4|23|Sets bit 7 of the memory location pointed to by iy plus *.">set 7,(iy+*),c</td>
          <td class="un" axis="------|4|23|Sets bit 7 of the memory location pointed to by iy plus *.">set 7,(iy+*),d</td>
          <td class="un" axis="------|4|23|Sets bit 7 of the memory location pointed to by iy plus *.">set 7,(iy+*),e</td>
          <td class="un" axis="------|4|23|Sets bit 7 of the memory location pointed to by iy plus *.">set 7,(iy+*),h</td>
          <td class="un" axis="------|4|23|Sets bit 7 of the memory location pointed to by iy plus *.">set 7,(iy+*),l</td>
          <td axis="------|4|23|Sets bit 7 of the memory location pointed to by iy plus *.">set 7,(iy+*)</td>
          <td class="un" axis="------|4|23|Sets bit 7 of the memory location pointed to by iy plus *.">set 7,(iy+*),a</td>
        </tr>
      </table>
      <div id="banner">
        <a href="/asm/">
          <span>one assembler to rule them all<br />~~~</span>
          <img src="/asm/bar.png" alt="ORG ONLINE Z80 IDE" />
        </a>
        <cite>
          <a href="/resources/">
            <img src="/images/emblem.png" alt="ClrHome" />
          </a>
          <span>another web<br />resource by</span>
        </cite>
        <img src="banner.png" alt="" />
      </div>
    </div>
  </body>
</html>
