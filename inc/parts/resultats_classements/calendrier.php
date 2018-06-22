<?php
$year = retourne_annee();
$dates = getAll($year);
$events = getEvents($year);?>
<div class="periods">
    <div class="year">
        <ul>
            <li><a href="#" id="linkYear<?php echo $year; ?>"><?php echo $year; ?></a></li>
            <li><a href="#" id="linkYear<?php echo $year+1; ?>"><?php echo $year+1; ?></a></li>
        </ul>
    </div>
    <div class="months">
        <ul><?php
            foreach($mois_de_lannee_min as $id=>$m) {?>
                <li><a href="#" id="linkMonth<?php echo $id+1; ?>"><?=$m; ?></a></li><?php
            }?>
        </ul>
    </div>
    <div class="clear_b"></div>
    <?php foreach($dates as $m=>$days) {?>
        <div class="month" id="month<?php echo $m ?>">
            <table>
                <thead>
                    <tr>
                        <?php foreach($jour_de_la_semaine as $d) {?>
                            <th><?php echo $d;?></th>
                            <?php
                        }?>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <?php
                        $end = end($days);
                        foreach($days as $d=>$w) {
                            if(strlen($m)==1) $new_m = '0'.$m; else $new_m = $m;
                            if(strlen($d)==1) $new_d = '0'.$d; else $new_d = $d;
                            if($m < 7) $new_y = $year+1; else $new_y = $year;
                            $time = $new_y.$new_m.$new_d;
                            if($d == 1 && $w-1 != 0) {?>
                                <td colspan="<?php echo $w-1; ?>"></td><?php
                            }
                            ?>
                            <td <?php echo liste_class($d, $m, $w); ?>>
                                <div class="relative">
                                    <div class="day"><?php echo $d ;?></div>
                                </div>
                                <div class="daylight"><?php echo date_toutes_lettres($d, $w, $m);?></div>
                                <div class="events">
                                    <span class="matchs"><?php
                                        if(isset($events[$time])) { echo count($events[$time])." match"; if(count($events[$time])>1) echo "s"; }?>
                                    </span>
                                    <span class="extra"><?php ?>
                                    </span>
                                </div>
                                <div class="laDate"><?php echo $time; ?></div>
                            </td><?php
                            if($w == 7) {?>
                                </tr><tr><?php
                            }
                        }
                        if($end != 7) {?>
                            <td colspan="<?php echo 7-$end; ?>"></td><?php
                        }?>
                    </tr>
                </tbody>
            </table>
        </div><?php
    }
    ?>
</div>