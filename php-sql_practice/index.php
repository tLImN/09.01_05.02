<?php
// n1
$host = 'localhost'; // Хост
$db = 'school_management'; // Имя базы данных
$user = 'root';      // Имя пользователя
$password = '';      // Пароль

$conn = new mysqli($host, $user, $password, $db);

if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}
echo "Соединение успешно установлено! ";

$action = $_GET['action'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	//n2
    if ($action === 'add_student') {
        $name = $_POST['name'];

        if (!empty($name)) {
            $stmt = $conn->prepare("INSERT INTO students (name) VALUES (?)");
            $stmt->bind_param("s", $name);

            if ($stmt->execute()) {
                echo "Студент добавлен успешно! ";
            } else {
                echo "Ошибка: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "Пожалуйста, укажите имя студента. ";
        }
    }
	
	//n3
	if ($action === 'add_group') {
        // Добавление новой группы
        $group_name = $_POST['group_name'];

        if (!empty($group_name)) {
            $stmt = $conn->prepare("INSERT INTO groups (name) VALUES (?)");
            $stmt->bind_param("s", $group_name);

            if ($stmt->execute()) {
                echo "Группа добавлена успешно!";
            } else {
                echo "Ошибка: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "Название группы не может быть пустым.";
        }
    }
	
	//n5
	if ($action === 'bind_student_to_group') {
        // Привязка студента к группе
        $student_id = $_POST['student_id'];
        $group_id = $_POST['group_id'];

        if (is_numeric($student_id) && is_numeric($group_id)) {
            $stmt = $conn->prepare("UPDATE students SET group_id = ? WHERE id = ?");
            $stmt->bind_param("ii", $group_id, $student_id);

            if ($stmt->execute()) {
                echo "Студент успешно привязан к группе!";
            } else {
                echo " Ошибка: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "Пожалуйста, выберите корректного студента и группу.";
        }
    }
	
    //n9
    if ($action === 'delete_student') {
        $student_id = $_POST['student_id'];

        if (is_numeric($student_id)) {
            $stmt = $conn->prepare("DELETE FROM students WHERE id = ?");
            $stmt->bind_param("i", $student_id);

            if ($stmt->execute()) {
                echo "Студент успешно удален.";
            } else {
                echo "Ошибка: " . $stmt->error;
            }
            $stmt->close();
        } else {
            echo "Некорректный ID студента.";
        }
    }
	
    //n10
    if ($action === 'update_student_name') {
        $student_id = $_POST['student_id'];
        $new_name = $_POST['new_name'];

        if (!empty($new_name) && is_numeric($student_id)) {
            $stmt = $conn->prepare("UPDATE students SET name = ? WHERE id = ?");
            $stmt->bind_param("si", $new_name, $student_id);

            if ($stmt->execute()) {
                echo "Имя студента успешно обновлено!";
            } else {
                echo "Ошибка: " . $stmt->error;
            }
            $stmt->close();
        } else {
            echo "Пожалуйста, заполните все поля корректно.";
        }
    }
	
    //n15
    if ($action === 'add_teacher') {
        $teacher_name = $_POST['teacher_name'];

        if (!empty($teacher_name)) {
            $stmt = $conn->prepare("INSERT INTO teachers (name) VALUES (?)");
            $stmt->bind_param("s", $teacher_name);

            if ($stmt->execute()) {
                echo "Преподаватель успешно зарегистрирован!";
            } else {
                echo "Ошибка: " . $stmt->error;
            }
            $stmt->close();
        } else {
            echo "Имя преподавателя не может быть пустым.";
        }
    }

    //n17
    if ($action === 'delete_course') {
        $course_id = $_POST['course_id'];

        if (is_numeric($course_id)) {
            $stmt = $conn->prepare("DELETE FROM courses WHERE id = ?");
            $stmt->bind_param("i", $course_id);

            if ($stmt->execute()) {
                echo "Курс успешно удален.";
            } else {
                echo "Ошибка: " . $stmt->error;
            }
            $stmt->close();
        } else {
            echo "Некорректный ID курса.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Управление студентами</title>
</head>
<body>
    <h1>Управление студентами</h1>

    <form method="get" action="">
		<p>Добавить:
        <button type="submit" name="action" value="add_student">Добавить нового студента</button>
		<button type="submit" name="action" value="add_group">Добавить новую группу</button>
		<button type="submit" name="action" value="add_course">Добавить новый курс</button>
		<button type="submit" name="action" value="add_teacher">Добавить преподавателя</button></p>
		<p>Изменить:
		<button type="submit" name="action" value="register_student_to_course">Регистрация студента на курс</button>
		<button type="submit" name="action" value="bind_student_to_group">Привязать студента к группе</button>
		<button type="submit" name="action" value="update_student_name">Обновить имя студента</button></p>
		<p>Просмотреть:
        <button type="submit" name="action" value="show_students">Просмотреть всех студентов</button>
		<button type="submit" name="action" value="show_students_with_groups">Просмотреть всех студентов с группами</button>
		<button type="submit" name="action" value="view_courses">Вывести курсы с количеством студентов</button>
		<button type="submit" name="action" value="view_teachers_courses">Вывести преподавателей и их курсы</button>
		<button type="submit" name="action" value="students_without_group">Студенты без группы</button>
		<button type="submit" name="action" value="students_multiple_courses">Студенты на нескольких курсах</button>
		<button type="submit" name="action" value="teachers_with_students">Преподаватели с количеством студентов</button></p>
		<p>Найти:
		<button type="submit" name="action" value="search_student">Поиск студента по имени</button>
		<button type="submit" name="action" value="search_course">Поиск студентов по курсу</button>
		<button type="submit" name="action" value="filter_students_by_group">Фильтр студентов по группе</button></p>
		<p>Удалить:
		<button type="submit" name="action" value="delete_course">Удалить курс</button>
        <button type="submit" name="action" value="delete_student">Удалить студента</button></p>
    </form>

    <hr>

    <?php
    //n2
    if ($action === 'add_student') {
        echo '<h2>Добавить нового студента</h2>';
        echo '<form method="post" action="?action=add_student">';
        echo '    <label for="name">Имя студента:</label><br>';
        echo '    <input type="text" id="name" name="name" required><br><br>';
        echo '    <input type="submit" value="Добавить">';
        echo '</form>';
    }

    //n3
    if ($action === 'show_students') {
        echo '<h2>Список студентов</h2>';
        $conn = new mysqli($host, $user, $password, $db);
        if ($conn->connect_error) {
            die("Ошибка подключения: " . $conn->connect_error);
        }

        $sql = "SELECT * FROM students";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo '<table border="1">';
            echo '<tr><th>ID</th><th>Имя</th><th>ID группы</th></tr>';
            while ($row = $result->fetch_assoc()) {
                echo '<tr><td>' . $row['id'] . '</td><td>' . $row['name'] . '</td><td>' . $row['group_id'] . '</td></tr>';
            }
            echo '</table>';
        } else {
            echo "Студенты отсутствуют в базе данных.";
        }

        $conn->close();
    }
	
    //n4
    if ($action === 'add_group') {
        echo '<h2>Добавить новую группу</h2>';
        echo '<form method="post" action="?action=add_group">';
        echo '    <label for="group_name">Название группы:</label><br>';
        echo '    <input type="text" id="group_name" name="group_name" required><br><br>';
        echo '    <input type="submit" value="Добавить">';
        echo '</form>';
    }

    //n5
    if ($action === 'bind_student_to_group') {
        echo '<h2>Привязать студента к группе</h2>';

        $conn = new mysqli($host, $user, $password, $db);
        if ($conn->connect_error) {
            die("Ошибка подключения: " . $conn->connect_error);
        }

        // Получение списка студентов
        $students = $conn->query("SELECT id, name FROM students");

        // Получение списка групп
        $groups = $conn->query("SELECT id, name FROM groups");

        echo '<form method="post" action="?action=bind_student_to_group">';
        echo '    <label for="student_id">Студент:</label><br>';
        echo '    <select id="student_id" name="student_id" required>';
        echo '        <option value="">-- Выберите студента --</option>';
        while ($student = $students->fetch_assoc()) {
            echo '<option value="' . $student['id'] . '">' . $student['name'] . '</option>';
        }
        echo '    </select><br><br>';

        echo '    <label for="group_id">Группа:</label><br>';
        echo '    <select id="group_id" name="group_id" required>';
        echo '        <option value="">-- Выберите группу --</option>';
        while ($group = $groups->fetch_assoc()) {
            echo '<option value="' . $group['id'] . '">' . $group['name'] . '</option>';
        }
        echo '    </select><br><br>';

        echo '    <input type="submit" value="Привязать">';
        echo '</form>';

        $conn->close();
    }
	
	//n6
	if ($action === 'show_students_with_groups') {
		$sql = "SELECT students.name AS student_name, groups.name AS group_name 
				FROM students 
				LEFT JOIN groups ON students.group_id = groups.id";
	
		$result = $conn->query($sql);
		
		if ($result->num_rows > 0) {
			echo "<h2>Список студентов с их группами</h2>";
			echo "<table border='1'>";
			echo "<tr><th>Имя студента</th><th>Группа</th></tr>";
			while ($row = $result->fetch_assoc()) {
				echo "<tr>";
				echo "<td>" . $row['student_name'] . "</td>";
				echo "<td>" . ($row['group_name'] ?? "Без группы") . "</td>";
				echo "</tr>";
			}
			echo "</table>";
		} else {
			echo "Нет данных для отображения.";
		}
	}
	
	//n7
	if ($action === 'register_student_to_course') {
    echo '<h2>Регистрация студента на курс</h2>';

		// Подключение к базе данных
		$conn = new mysqli($host, $user, $password, $db);
		if ($conn->connect_error) {
			die("Ошибка подключения: " . $conn->connect_error);
		}

		// Получение списка студентов
		$students = $conn->query("SELECT id, name FROM students");
	
		// Получение списка курсов
		$courses = $conn->query("SELECT id, name FROM courses");
	
		echo '<form method="post" action="?action=register_student_to_course">';
		echo '    <label for="student_id">Студент:</label><br>';
		echo '    <select id="student_id" name="student_id" required>';
		echo '        <option value="">-- Выберите студента --</option>';
		while ($student = $students->fetch_assoc()) {
			echo '<option value="' . $student['id'] . '">' . $student['name'] . '</option>';
		}
		echo '    </select><br><br>';
	
		echo '    <label for="course_id">Курс:</label><br>';
		echo '    <select id="course_id" name="course_id" required>';
		echo '        <option value="">-- Выберите курс --</option>';
		while ($course = $courses->fetch_assoc()) {
			echo '<option value="' . $course['id'] . '">' . $course['name'] . '</option>';
		}
		echo '    </select><br><br>';
	
		echo '    <input type="submit" value="Зарегистрировать">';
		echo '</form>';

		// Обработка отправленной формы
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$student_id = $_POST['student_id'];
			$course_id = $_POST['course_id'];

			if (!empty($student_id) && !empty($course_id)) {
				// Проверяем, есть ли уже запись с таким студентом и курсом
				$check_sql = "SELECT * FROM student_courses WHERE student_id = ? AND course_id = ?";
				$stmt = $conn->prepare($check_sql);
				$stmt->bind_param("ii", $student_id, $course_id);
				$stmt->execute();
				$result = $stmt->get_result();

				if ($result->num_rows > 0) {
					echo "Студент уже зарегистрирован на выбранный курс.";
				} else {
					// Если записи нет, добавляем ее
					$insert_sql = "INSERT INTO student_courses (student_id, course_id) VALUES (?, ?)";
					$stmt = $conn->prepare($insert_sql);
					$stmt->bind_param("ii", $student_id, $course_id);

					if ($stmt->execute()) {
						echo "Студент успешно зарегистрирован на курс.";
					} else {
						echo "Ошибка при регистрации: " . $conn->error;
					}

					$stmt->close();
				}
			} else {
				echo "Пожалуйста, выберите студента и курс.";
			}
		}
	}
	
	//n8
    if ($action === 'view_courses') {
        echo '<h2>Курсы и количество студентов</h2>';
        $sql = "SELECT courses.id AS course_id, courses.name AS course_name, COUNT(student_courses.student_id) AS student_count 
            FROM courses 
            LEFT JOIN student_courses ON courses.id = student_courses.course_id 
            GROUP BY courses.id, courses.name";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo '<table border="1">';
            echo '<tr><th>ID курса</th><th>Курс</th><th>Количество студентов</th></tr>';

            while ($row = $result->fetch_assoc()) {
                echo '<tr>';
				echo '<td>' . htmlspecialchars($row['course_id']) . '</td>'; // Вывод ID курса
				echo '<td>' . htmlspecialchars($row['course_name']) . '</td>'; // Вывод названия курса
				echo '<td>' . htmlspecialchars($row['student_count']) . '</td>'; // Вывод количества студентов
				echo '</tr>';
            }

            echo '</table>';
        } else {
            echo 'Нет курсов или зарегистрированных студентов.';
        }
    }

    //n9
    if ($action === 'delete_student') {
        echo '<h2>Удалить студента</h2>';
        echo '<form method="post" action="?action=delete_student">';
        echo '    <label for="student_id">ID студента:</label><br>';
        echo '    <input type="number" id="student_id" name="student_id" required><br><br>';
        echo '    <input type="submit" value="Удалить">';
        echo '</form>';
    }

    //n10
    if ($action === 'update_student_name') {
        echo '<h2>Обновить имя студента</h2>';
        echo '<form method="post" action="?action=update_student_name">';
        echo '    <label for="student_id">ID студента:</label><br>';
        echo '    <input type="number" id="student_id" name="student_id" required><br><br>';
        echo '    <label for="new_name">Новое имя студента:</label><br>';
        echo '    <input type="text" id="new_name" name="new_name" required><br><br>';
        echo '    <input type="submit" value="Обновить">';
        echo '</form>';
    }
	
    //n11
    if ($action === 'view_teachers_courses') {
        echo '<h2>Преподаватели и их курсы</h2>';
        $sql = "SELECT teachers.name AS teacher_name, courses.name AS course_name 
                FROM teachers 
                LEFT JOIN courses ON teachers.id = courses.teacher_id";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo '<table border="1">';
            echo '<tr><th>Преподаватель</th><th>Курс</th></tr>';

            while ($row = $result->fetch_assoc()) {
                echo '<tr><td>' . $row['teacher_name'] . '</td><td>' . $row['course_name'] . '</td></tr>';
            }

            echo '</table>';
        } else {
            echo 'Нет данных о преподавателях или курсах.';
        }
    }

	//n12
    if ($action === 'search_student') {
        echo '<h2>Поиск студента по имени</h2>';
        echo '<form method="post" action="?action=search_student">';
        echo '    <label for="student_name">Имя студента:</label><br>';
        echo '    <input type="text" id="student_name" name="student_name" required><br><br>';
        echo '    <input type="submit" value="Поиск">';
        echo '</form>';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $student_name = $_POST['student_name'];

            $sql = "SELECT students.name AS student_name, groups.name AS group_name 
                    FROM students 
                    LEFT JOIN groups ON students.group_id = groups.id 
                    WHERE students.name LIKE ?";
            
            $stmt = $conn->prepare($sql);
            $name_filter = "%$student_name%";
            $stmt->bind_param("s", $name_filter);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                echo '<h2>Результаты поиска:</h2>';
                echo '<table border="1">';
                echo '<tr><th>Имя студента</th><th>Группа</th></tr>';
                while ($row = $result->fetch_assoc()) {
                    echo '<tr><td>' . htmlspecialchars($row['student_name']) . '</td><td>' . ($row['group_name'] ?? 'Нет группы') . '</td></tr>';
                }
                echo '</table>';
            } else {
                echo 'Студент с таким именем не найден.';
            }
        }
    }

    //n13
    if ($action === 'students_without_group') {
        echo '<h2>Студенты без группы</h2>';
        $sql = "SELECT name AS student_name FROM students WHERE group_id IS NULL";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo '<ul>';
            while ($row = $result->fetch_assoc()) {
                echo '<li>' . $row['student_name'] . '</li>';
            }
            echo '</ul>';
        } else {
            echo 'Нет студентов без группы.';
        }
    }
	
    //n14
    if ($action === 'add_course') {
		$teachers = $conn->query("SELECT id, name FROM teachers");
		
        echo '<h2>Добавить новый курс</h2>';
        echo '<form method="post" action="?action=add_course">';
		
        echo '    <label for="course_name">Название курса:</label><br>';
        echo '    <input type="text" id="course_name" name="course_name" required><br><br>';
		
		echo '    <label for="teacher_id">Преподаватель:</label><br>';
		echo '    <select id="teacher_id" name="teacher_id" required>';
		echo '        <option value="">-- Преподаватель --</option>';
		while ($teacher = $teachers->fetch_assoc()) {
			echo '<option value="' . $teacher['id'] . '">' . $teacher['name'] . '</option>';
		}
		echo '    </select><br><br>';
		
        echo '    <input type="submit" value="Добавить">';
        echo '</form>';
		
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$course_name = $_POST['course_name'] ?? null;
			$teacher_id = $_POST['teacher_id'] ?? null;

			if (!empty($course_name) && !empty($teacher_id)) {
				echo "Название курса: $course_name, ID преподавателя: $teacher_id ";
			} else {
				echo "Данные не переданы: проверьте форму! ";
			}
			
			if (!empty($course_name) && !empty($teacher_id)) {
				// Подготавливаем запрос для вставки нового курса
				$insert_sql = "INSERT INTO courses (name, teacher_id) VALUES (?, ?)";
				$stmt = $conn->prepare($insert_sql);
				$stmt->bind_param("si", $course_name, $teacher_id);
	
				// Выполняем запрос
				if ($stmt->execute()) {
					echo "Курс успешно добавлен.";
				} else {
					echo "Ошибка при добавлении курса: " . $conn->error;
				}
				$stmt->close();
				} else {
					echo "Введите преподавателя и курс.";
				}
		}
	}

    //n15
    if ($action === 'add_teacher') {
		
        echo '<h2>Зарегистрировать нового преподавателя</h2>';
        echo '<form method="post" action="?action=add_teacher">';
        echo '    <label for="teacher_name">Имя преподавателя:</label><br>';
        echo '    <input type="text" id="teacher_name" name="teacher_name" required><br><br>';
        echo '    <input type="submit" value="Зарегистрировать">';
        echo '</form>';
    }

    //n16
    if ($action === 'search_course') {
        echo '<h2>Поиск студентов по названию курса</h2>';
        echo '<form method="post" action="?action=search_course">';
        echo '    <label for="course_name">Название курса:</label><br>';
        echo '    <input type="text" id="course_name" name="course_name" required><br><br>';
        echo '    <input type="submit" value="Поиск">';
        echo '</form>';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $course_name = $_POST['course_name'];

            $sql = "SELECT students.name AS student_name 
                    FROM students 
                    JOIN student_courses ON students.id = student_courses.student_id
					 JOIN courses ON student_courses.course_id = courses.id 
                    WHERE courses.name = ?";
            
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $course_name);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                echo '<h2>Студенты, зарегистрированные на курс "' . htmlspecialchars($course_name) . '"</h2>';
                echo '<ul>';
                while ($row = $result->fetch_assoc()) {
                    echo '<li>' . $row['student_name'] . '</li>';
                }
                echo '</ul>';
            } else {
                echo 'На данном курсе нет зарегистрированных студентов или курс не найден.';
            }
        }
    }

    //n17
    if ($action === 'delete_course') {
        echo '<h2>Удалить курс</h2>';
        echo '<form method="post" action="?action=delete_course">';
        echo '    <label for="course_id">ID курса:</label><br>';
        echo '    <input type="number" id="course_id" name="course_id" required><br><br>';
        echo '    <input type="submit" value="Удалить">';
        echo '</form>';
    }

    //n18
    if ($action === 'filter_students_by_group') {
        echo '<h2>Фильтр студентов по группе</h2>';
        echo '<form method="post" action="?action=filter_students_by_group">';
        echo '    <label for="group_name">Группа:</label><br>';
		echo '    <input type="text" id="group_name" name="group_name" required><br><br>';
		echo '    <input type="submit" value="Фильтр">';
        echo '</form>';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $group_name = $_POST['group_name'];

			if (!empty($group_name)) {
				$sql_find_group = "SELECT id FROM groups WHERE name = ?";
				$stmt_find_group = $conn->prepare($sql_find_group);
				$stmt_find_group->bind_param("s", $group_name);
				$stmt_find_group->execute();
				$result_find_group = $stmt_find_group->get_result();

				if ($result_find_group->num_rows > 0) {
					$group_row = $result_find_group->fetch_assoc();
					$group_id = $group_row['id'];
					
				$sql = "SELECT students.name AS student_name 
						FROM students 
						WHERE group_id = ?";
				$stmt = $conn->prepare($sql);
				$stmt->bind_param("i", $group_id);
				$stmt->execute();
				$result = $stmt->get_result();

				if ($result->num_rows > 0) {
					echo '<h2>Студенты из группы ' . htmlspecialchars($group_name) . '</h2>';
					echo '<ul>';
					while ($row = $result->fetch_assoc()) {
						echo '<li>' . htmlspecialchars($row['student_name']) . '</li>';
					}
					echo '</ul>';
					} else {
						echo 'В этой группе нет студентов. ';
					}
				} else {
					echo 'Группа с таким именем не найдена. ';
				}
			} else {
				echo 'Введите корректное имя группы. ';
			}
		}
	}

    //n19
    if ($action === 'students_multiple_courses') {
        echo '<h2>Студенты, зарегистрированные на несколько курсов</h2>';
        $sql = "SELECT students.name AS student_name, COUNT(student_courses.course_id) AS course_count 
                FROM students
				JOIN student_courses ON students.id = student_courses.student_id 
                GROUP BY students.id 
                HAVING course_count > 1";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo '<table border="1">';
            echo '<tr><th>Имя студента</th><th>Количество курсов</th></tr>';

            while ($row = $result->fetch_assoc()) {
                echo '<tr><td>' . $row['student_name'] . '</td><td>' . $row['course_count'] . '</td></tr>';
            }

            echo '</table>';
        } else {
            echo 'Нет студентов, зарегистрированных на несколько курсов.';
        }
    }

    //n20
    if ($action === 'teachers_with_students') {
        echo '<h2>Преподаватели с количеством их студентов</h2>';
        $sql = "SELECT teachers.name AS teacher_name, COUNT(student_courses.student_id) AS total_students 
                FROM teachers 
                JOIN courses ON teachers.id = courses.teacher_id 
                JOIN student_courses ON courses.id = student_courses.course_id 
                GROUP BY teachers.id";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo '<table border="1">';
            echo '<tr><th>Преподаватель</th><th>Количество студентов</th></tr>';

            while ($row = $result->fetch_assoc()) {
                echo '<tr><td>' . $row['teacher_name'] . '</td><td>' . $row['total_students'] . '</td></tr>';
            }

            echo '</table>';
        } else {
            echo 'Нет информации о преподавателях и их студентах.';
        }
    }
?>
</body>
</html>