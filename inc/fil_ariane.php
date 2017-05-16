<div class="container">
    <nav class="fil-ariane">
        <ul>
            <li class="nav navhome"><a href="index.php"><?=$filAriane[0];?></a></li><?php
            if(!empty($filAriane[2])) :
                if(is_array($filAriane[2])) :?>
                    <li class="nav navtit"><a href="<?=$filAriane[1];?>.php"><?=$filAriane[1];?></a></li>
                    <li class="nav navcat"><a href="<?=$filAriane[1];?>.php?onglet=<?=$filAriane[2]['raccourci'];?>"><?=$filAriane[2]['categorie'];?></a></li>
                    <li><a href="<?=$filAriane[1];?>.php?onglet=<?=$filAriane[2]['raccourci'];?>"><?=$filAriane[2]['genre'];?></a></li><?php
                else:?>
                    <li class="nav navtit2"><a href="<?=$filAriane[1];?>.php"><?=$filAriane[1];?></a></li>
                    <li><a href="<?=$filAriane[1];?>.php?onglet=<?=$filAriane[2];?>"><?=$filAriane[2];?></a></li><?php
                endif;
            else :?>
                <li class="nav navtit2"><a href="<?=$filAriane[1];?>.php"><?=$filAriane[1];?></a></li><?php
            endif;?>
        </ul>
    </nav>
</div>