<?php
	//№ 1
	if (isset($_GET['celsius'])) {
        $celsius = $_GET['celsius'];
        $fheit = ($celsius * 9 / 5) + 32;
        echo "t: " . $fheit . " °F";
    }
	
	//№ 2
	if (isset($_GET['number'])) {
        $num = intval($_GET['number']);
        $factorial = 1;

        for ($i = 1; $i <= $num; $i++) {
            $factorial *= $i;
        }

        echo "Факториал: " . $factorial;
    }
	
	//№ 3
	if (isset($_GET['number'])) {
        $num = intval($_GET['number']);
        $div = [];

        for ($i = 1; $i <= $num; $i++) {
            if ($num % $i == 0) {
                $div[] = $i;
            }
        }

        echo "Делители: " . implode(', ', $div);
    }
	
	//№ 4
	if (isset($_GET['number1']) && isset($_GET['number2'])) {
        $num1 = intval($_GET['number1']);
        $num2 = intval($_GET['number2']);
        $commonDiv = [];

        $minNum = min($num1, $num2);

        for ($i = 1; $i <= $minNum; $i++) {
            if ($num1 % $i == 0 && $num2 % $i == 0) {
                $commonDiv[] = $i;
            }
        }

        echo "Общие делители: " . implode(', ', $commonDiv);
    }
	
	//№ 5
	if (isset($_GET['a']) && isset($_GET['b']) && isset($_GET['c'])) {
        $a = intval($_GET['a']);
        $b = intval($_GET['b']);
        $c = intval($_GET['c']);
        $discriminant = $b * $b - 4 * $a * $c;

        if ($discriminant > 0) {
            $root1 = (-$b + sqrt($discriminant)) / (2 * $a);
            $root2 = (-$b - sqrt($discriminant)) / (2 * $a);
            echo "Корни уравнения: x1 = $root1, x2 = $root2";
        } elseif ($discriminant == 0) {
            $root = -$b / (2 * $a);
            echo "Корень уравнения: x = $root";
        } else {
            echo "Уравнение не имеет действительных корней";
        }
    }
	
	//№ 6
	if (isset($_GET['num1']) && isset($_GET['num2']) && isset($_GET['num3'])) {
        $nums = [
            intval($_GET['num1']),
            intval($_GET['num2']),
            intval($_GET['num3'])
        ];
		
        sort($nums);

        $a = $nums[0];
        $b = $nums[1];
        $c = $nums[2];

        if ($c * $c == $a * $a + $b * $b) {
            echo "Числа являются тройкой Пифагора";
        } else {
            echo "Числа не являются тройкой Пифагора";
        }
    }
	
	//№ 7
	if (isset($_GET['birthdate'])) {
        $bthdate = DateTime::createFromFormat('d.m.Y', $_GET['birthdate']);
        if ($bthdate) {
            $currYr = date('Y');
            $nxtBthday = DateTime::createFromFormat('d.m.Y', $bthdate->format('d.m') . '.' . $currYr);

            if ($nxtBthday < new DateTime()) {
                $nxtBthday->modify('+1 year');
            }

            $interval = (new DateTime())->diff($nxtBthday);
            echo "До дня рождения осталось: " . $interval->days . " дней";
        } else {
            echo "Неверный формат даты.";
        }
    }
	
	//№ 8
	if (isset($_GET['text'])) {
        $text = $_GET['text'];
        $wrdCnt = str_word_count($text, 0, 'АаБбВвГгДдЕеЁёЖжЗзИиЙйКкЛлМмНнОоПпРрСсТтУуФфХхЦцЧчШшЩщЪъЫыЬьЭэЮюЯя');
        $chrCnt = mb_strlen($text, 'UTF-8');

        echo "Кол-во слов: $wrdCnt<br>";
        echo "Кол-во символов: $chrCnt";
    }
	
	//№ 9
	if (isset($_GET['text'])) {
        $text = $_GET['text'];
        $totalChrs = mb_strlen($text, 'UTF-8');
        $charFreq = [];
        
        for ($i = 0; $i < $totalChrs; $i++) {
            $char = mb_substr($text, $i, 1, 'UTF-8');
            if (!isset($charFreq[$char])) {
                $charFreq[$char] = 0;
            }
            $charFreq[$char]++;
        }

        echo "Процентное содержание символов:<br>";
        foreach ($charFreq as $char => $count) {
            $percntge = ($count / $totalChrs) * 100;
            echo htmlspecialchars($char) . ": " . number_format($percntge, 2) . "%<br>";
		}
	}
	
	//№ 10
	   if (isset($_GET['day']) && isset($_GET['month']) && isset($_GET['year'])) {
        $day = $_GET['day'];
        $month = $_GET['month'];
        $year = $_GET['year'];
        
        $dateStr = "$year-$month-$day";
        $date = DateTime::createFromFormat('Y-m-d', $dateStr);
        
        if ($date) {
            $weekDays = ['Воскресенье', 'Понедельник', 'Вторник', 'Среда', 'Четверг', 'Пятница', 'Суббота'];
            $weekDay = $weekDays[$date->format('w')];
            echo "Выбранная дата $dateStr это $weekDay.";
        } else {
            echo "Неверная дата.";
        }
    }
	
	//№ 11
	function getZodiacSign($day, $month) {
        $zdcSigns = [
            'Козерог' => ['start' => '12-22', 'end' => '01-19'],
            'Водолей' => ['start' => '01-20', 'end' => '02-18'],
            'Рыбы' => ['start' => '02-19', 'end' => '03-20'],
            'Овен' => ['start' => '03-21', 'end' => '04-19'],
            'Телец' => ['start' => '04-20', 'end' => '05-20'],
            'Близнецы' => ['start' => '05-21', 'end' => '06-20'],
            'Рак' => ['start' => '06-21', 'end' => '07-22'],
            'Лев' => ['start' => '07-23', 'end' => '08-22'],
            'Дева' => ['start' => '08-23', 'end' => '09-22'],
            'Весы' => ['start' => '09-23', 'end' => '10-22'],
            'Скорпион' => ['start' => '10-23', 'end' => '11-21'],
            'Стрелец' => ['start' => '11-22', 'end' => '12-21'],
        ];

        foreach ($zdcSigns as $sign => $dates) {
            $start = explode('-', $dates['start']);
            $end = explode('-', $dates['end']);
            if (($month == $start[0] && $day >= $start[1]) || ($month == $end[0] && $day <= $end[1])) {
                return $sign;
            }
        }
        return null;
    }
	
    $hrscopes = [
		'Козерог' => 'На работе ожидаются позитивные изменения и возможность роста.',  
		'Водолей' => 'Интуиция сегодня будет вашим надёжным советчиком.',
		'Рыбы' => 'Творческие идеи и вдохновение придут в самые неожиданные моменты.',
		'Овен' => 'Сегодня день будет благоприятным для начала новых дел.',
		'Телец' => 'Обратите внимание на здоровье сегодня.',
		'Близнецы' => 'Ваши усилия на работе обязательно принесут результаты.',
		'Рак' => 'Сегодня ваши финансы могут потребовать особого внимания и планирования.',
		'Лев' => 'Время для самовыражения и проведения времени с близкими.',
		'Дева' => 'Организованность поможет вам справиться с любыми задачами.',
		'Весы' => 'Обратите внимание на своё здоровье и личное благополучие.',
		'Скорпион' => 'День идеален для решительных шагов в личной жизни.',
		'Стрелец' => 'Приключения и новые впечатления не заставят себя ждать.',
    ];
	
    if (isset($_GET['birthdate'])) {
		$bthdate = DateTime::createFromFormat('d.m.Y', $_GET['birthdate']);
        if ($bthdate) {
            $sign = getZodiacSign($bthdate->format('d'), $bthdate->format('m'));
            if ($sign && isset($hrscopes[$sign])) {
                echo "Ваш знак зодиака: $sign.<br>";
                echo "Предсказание: " . $hrscopes[$sign];
            } else {
                echo "Гороскоп для вашего знака не доступен.";
            }
        } else {
            echo "Неверный формат даты.";
        }
    }
?>