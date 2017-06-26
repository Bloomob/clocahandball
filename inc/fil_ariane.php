<div class="container">
    <nav class="fil-ariane">
        <ul>
            <li class="nav navhome"><a href="index.php"><?=$filAriane[0];?></a></li><?php
            if(!empty($filAriane[2])) :
                if(is_array($filAriane[2])) :
                    if(isset($filAriane[3])):?>
                        <li class="nav navtit"><a href="<?=$filAriane[1]['url'];?>.php"><?=$filAriane[1]['libelle'];?></a></li>
                        <li class="nav navcat"><a href="<?=$filAriane[1]['url'];?>.php?onglet=<?=$filAriane[2]['url'];?>"><?=$filAriane[2]['libelle'];?></a></li><?php
                    else:?>
                        <li class="nav navtit2"><a href="<?=$filAriane[1]['url'];?>.php"><?=$filAriane[1]['libelle'];?></a></li><?php
                        foreach($filAriane[2] as $fil):?>
                            <li class="nav"><a href="<?=$filAriane[1]['url'];?>.php?onglet=<?=$fil['url']?>"><?=$fil['libelle']?></a></li><?php
                        endforeach;
                    endif;
                endif;
            else:?>
                <li class="nav navtit2"><a href="<?=$filAriane[1]['url'];?>.php"><?=$filAriane[1]['libelle'];?></a></li><?php
            endif;?>
        </ul>
    </nav>
</div>