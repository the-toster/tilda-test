# Несколько простых задач, для понимания моего подхода к разработке

Оригинал задания расположен тут - https://task4developer.tilda.ws/backend-easy-task

## Отражение подхода

По обыкновению начал с затаскивания в проект основных рабочих инструментов &mdash; `phpunit` и `paslm`.  
Потом идет `README.md`, всегда помогает направить размышления и занять сторону потребителя.
Я постарался изложить в этом ридми свои решения и мотивацию стоящую за ними, рассматривая задачи как свои обычные рабочие. 


## Тесты

Предпочитаю писать в underscore нотации, чтобы получать красивый вывод с флагом `--testdox`, полюбоваться можно так:

```shell
composer run test
```

## Задача 1: лесенка

Нужно вывести лесенкой числа от 1 до 100.

```
 1
 2 3
 4 5 6
 ...
 ```

Пример работы решения можно получить запустив `show_stairs.php`:

```shell
php show_stairs.php
```

Решение реализованно в виде value-object'а `App\Stairs`. `VO` наделяет данные смыслами из предметной области, 
типизирует, их удобно тестировать, и, как показывает практика, даже у самых простых данных есть поведение &mdash;
например лесенка умеет представляться в виде строки.  

Интерфейс лесенки:

```php
App\Stairs::buildTo(6) // именованный конструктор, это обширная тема, почему именно так
    ->asString();      // получаем строковое представление, магия __toString() - это магия, поэтому - нет
```

## Задача 2: массивы

Нужно заполнить массив 5 на 7 случайными уникальными числами от 1 до 1000.  
Вывести получившийся массив и суммы по строкам и по столбцам.

Пример работы решения:

```php
php show_array.php
```
Код можно увидеть в модуле `App\Matrix`.  
Условия задачи позволяют отразить применяемый мной подход по разделению чистого и IO кода, позаимствованный у
Маттиаса Нобака, из его замечательной
книги [Advanced Web Application Architecture](https://leanpub.com/web-application-architecture/).
<details>
<summary>О подходе и его результатах</summary>

Суть подхода заключается в явном разделении на логическом и физическом уровне кода предметной области (чистого)
и кода инфраструктурного (IO), и контроля направления зависимостей.

- На логическом уровне, я следую правилу, что мои сущности, доменные сервисы, объекты-значения и DTO &mdash; чистые.
- Под физическим разделением я имею в виду раскладывание кода по папочкам. Внутри модуля всё IO я складываю
  в `Infrastructure`.
- Контроль направления зависимостей подразумевает запрет на зависимость от инфраструктуры.

Так же, кроме разделения на чистый / не чистый код, использую разделение чистого кода на 2 вида объектов.  
Грубо говоря, `сервисы` и `доменные объекты` (хотя они и те и те доменные конечно). Это опять же наработка Нобака,
озвученная в другой его прекрасной книге
[Object Design Style Guide](https://www.manning.com/books/object-design-style-guide).
 
`Сервисы` это stateless объекты для манипуляции со вводом и доменными объектами, под `доменными объектами` понимаются
объекты для хранения состояния (естественно, и поведение и инварианты остаются в них).
Сущности, VO, DTO. Для этой пары так же действует естественное правило для направления зависимостей и другие интересные
закономерности.

В результате применения такого подхода, код удовлетворяет луковой (и гексагональной) архитектуре:
в центре находятся `доменные объекты`, вокруг `сервисы`, и на внешнем уровне - инфраструктура.

</details>

Источник случайности в данной задаче &mdash; классический пример IO.
Поэтому он отделяется интерфейсом, что позволяет тестировать используя детерминированную реализацию.

<details>
    <summary>Неочевидный момент в объекте матрицы</summary>

Для подсчета сумм, используется транспонирование, элегантный способ построения
которого был получен со [stackoverflow](https://stackoverflow.com/questions/797251/transposing-multidimensional-arrays-in-php):
и сначала выглядел примерно так:
```php
    public function transpose(): self
    {
        return new self(array_map($callback, ...$this->rows));
    }
```
Это работает, потому что `array_map()` при пустом колбэке выполняет [`zip` над остальными аргументами](https://www.php.net/manual/en/function.array-map.php).  
Операция `zip` берет два списка и превращает их в один список пар. Или три списка в один список троек. И т.д.  
_(Мне она знакома из начального курса хаскеля - да, я рисуюсь, это же тестовое задание))_

Как выяснилось, это элегантное транспонирование не работает для однострочной матрицы, что логично:

```php
array_map(null, ...[[1, 2, 3]])
// превращается в
array_map(null, [1, 2, 3])
// зиповать не с чем, получаем вектор вместо матрицы
[1, 2, 3]
```

Поэтому в итоге однострочная матрица обрабатываться как особый случай, другим колбэком.
</details>

Для рисования таблички с матрицей я взял малоизвестную библиотеку, но она поддерживается и основана на `laminas/laminas-text`,
(это бывший `zendframework/zend-text`) то есть, определенное доверие к ней есть. Тащить сюда `symfony/console` я не стал)).
