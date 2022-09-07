<?php
include ("url_slug.php");
header('Content-type: text/html; charset=utf-8');

echo "Начинаем загрузку!<br>";
$host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "compshop";

$mysql = @mysqli_connect($host, $db_user, $db_pass);
$reader = new XMLReader();

if(mysqli_select_db($mysql, $db_name)) {
    echo "БД успешно подключена<br>";
    if (!$reader->open("../import/katran.xml")) {
        die("Failed to open 'katran.xml'");
    }
// обработка категорий товаров
    echo "Начинаем выбор категорий<br>";
    while ($reader->read()) {
        if ($reader->nodeType == XMLReader::ELEMENT && $reader->name == 'category') {
            $id = $reader->getAttribute('id');
            $parent = $reader->getAttribute('parent');
            $reader->read();
            if ($reader->nodeType == XMLReader::TEXT) {
                $name = mysqli_real_escape_string($mysql, $reader->value);
            } else {
                $name = "Категория ".$id;
            }
            //echo "Обрабатывем категорию ".$id."<br>";
            $slug = url_slug($name." ".$id);
// проверяем slug на уникальность
//            $query = "SELECT id FROM categories WHERE (id<>".$id.") AND (slug='".$slug."')";
//            $result = mysqli_query($mysql, $query);
//            if(mysqli_num_rows($result)>0) {
//                $slug = $slug . $id;
//            }
// сохранить категорию в справочник
            $query = "SELECT id FROM categories WHERE id=".$id;
            $result = mysqli_query($mysql, $query);
            if (mysqli_num_rows($result)>0) {
                $query = "UPDATE categories SET parent_id=".$parent.", name='".$name."', slug='".$slug."' WHERE id=".$id;
            } else {
                $query = "INSERT INTO categories  (id, parent_id, name, content, slug, image) VALUES (".$id.", ".$parent.", '".$name."', '', '".$slug."', '')";
            }
            //echo $query."<br>";
            //$result = mysqli_query($mysql, $query);
            //$query = "UPDATE categories SET chld_ct=chld_ct+1 WHERE id=".$parent;
            //$result = mysqli_query($mysql, $query);
        } elseif ($reader->nodeType == XMLReader::ELEMENT && $reader->name == 'products') {
            break;
        }
    }
    echo "Начинаем выбор товаров<br>";$i=0;
    while ($reader->read()) {
        if ($reader->nodeType == XMLReader::ELEMENT && $reader->name == 'product') {
            $id = $reader->getAttribute('id');
// получаем изображение
            while ($reader->read()) {
                if($reader->name == "image") {
                    $reader->read();
                    if ($reader->nodeType == XMLReader::TEXT) {
                        $image = $reader->value;
                    }
                    break;
                }
            }
            while ($reader->read()) {
                if($reader->name == "categoryId") {
                    $reader->read();
                    if ($reader->nodeType == XMLReader::TEXT) {
                        $category_id = $reader->value;
                    }
                    break;
                }
            }
            while ($reader->read()) {
                if($reader->name == "code") {
                    $reader->read();
                    if ($reader->nodeType == XMLReader::TEXT) {
                        $kod = $reader->value;
                    }
                    break;
                }
            }
            while ($reader->read()) {
                if($reader->name == "artikul") {
                    $reader->read();
                    if ($reader->nodeType == XMLReader::TEXT) {
                        $artikul = $reader->value;
                    }
                    break;
                }
            }
            while ($reader->read()) {
                if($reader->name == "name") {
                    $reader->read();
                    if ($reader->nodeType == XMLReader::TEXT) {
                        $name = mysqli_real_escape_string($mysql, $reader->value);
                    }
                    break;
                }
            }
            while ($reader->read()) {
                if($reader->name == "description") {
                    $reader->read();
                    if ($reader->nodeType == XMLReader::TEXT) {
                        $content = mysqli_real_escape_string($mysql, $reader->value);
                    }
                    break;
                }
            }
            while ($reader->read()) {
                if($reader->name == "pricediler") {
                    $reader->read();
                    if ($reader->nodeType == XMLReader::TEXT) {
                        $price_opt = $reader->value;
                        $price_opt = $price_opt*1.05;
                    }
                    break;
                }
            }
            while ($reader->read()) {
                if($reader->name == "pricerozn") {
                    $reader->read();
                    if ($reader->nodeType == XMLReader::TEXT) {
                        $price = $reader->value;
                        $price = $price*1.05;
                    }
                    break;
                }
            }
            $slug = "product_".$id;
            $query = "SELECT kod FROM products WHERE id='".$id."'";
            $result = mysqli_query($mysql, $query);
            if (mysqli_num_rows($result)>0) {
                $query = "UPDATE products SET kod='".$kod."', artikul='".$artikul."', name='".$name."', category_id="
                    .$category_id.", content='".$content."', image='".$image."', slug='".$slug."', price='"
                    .$price."', price_opt='".$price_opt."' WHERE id=".$id;
            } else {
                $query = "INSERT INTO products (id, kod, artikul, category_id, brand_id, name, content, slug, image, price, price_opt) VALUES
                        (".$id.",'".$kod."','".$artikul."',".$category_id.",1,'".$name."','".$content."','".$slug."','".$image."','".$price."','".$price_opt."')";
            }
            //echo $query."<br>";
            if($i>30000) {
                $result = mysqli_query($mysql, $query);
            }
            $i++;
            if ($i>33000) {
                break;
            }
        }
    }
    $reader->close();
} else {
    die("Ошибка подключения к БД compshop!");
}
