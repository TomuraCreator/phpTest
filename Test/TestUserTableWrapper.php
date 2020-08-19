<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use Application\UserTableWrapper;

final class TestUserTableWrapper extends TestCase
{
    /**
     * @test
     */
    public function headersIsString()
    {
        $userTable = new UserTableWrapper();
        $this->assertContainsOnly('string', $userTable->get()[0], null, 'Все оглавления типа string');
    }

    /**
     * @test
     */
    public function countCol()
    {
        $userTable = new UserTableWrapper();
        $this->assertCount(4 , $userTable->get()[0], 'Количество столбцов оглавлений таблицы');
    }

    /**
     * @test
     * @dataProvider driverColumn
     */
    public function columnNamesIsExist(string $assertion, array $targetArray)
    {
        $this->assertContains($assertion, $targetArray, 'Не совпадение имён оглавлений таблицы');
    }

    public function driverColumn()
    {
        $userTable = new UserTableWrapper();
        $targetArray = $userTable->get()[0];
        return array(
            array('id', $targetArray),
            array('name', $targetArray),
            array('surname', $targetArray),
            array('email', $targetArray)
        );
    }

    /**
     * @name
     * @test
     * @dataProvider providerInsert
     */
    public function validateInserting($assertion, array $targetArray)
    {
        $this->assertContains($assertion, $targetArray, 'Метод insert не работает');
    }

    public function providerInsert()
    {
        $targetArray = [];
        try {
            $userTable = new UserTableWrapper();
            $userTable->insert(array(1, 'Totoshka', 'Rastotoshka', 'ararara@gmail.com'));
            $targetArray = $userTable->get()[1];
        } catch (Exception $e) {
            // незнаю как бросить ошибку теста здесь
        }

        return array(
            array(1, $targetArray),
            array('Totoshka', $targetArray),
            array('Rastotoshka', $targetArray),
            array('ararara@gmail.com', $targetArray)
        );
    }

    /**
     * @test
     */
    public function checkDeleteMethod()
    {
        $targetArray = [];
        try {
            $userTable = new UserTableWrapper();
            $userTable->insert([1, 'Totoshka', 'Rastotoshka', 'ararara@gmail.com']);
            $userTable->delete(1);
            $targetArray = $userTable->get();
        } catch (Exception $e) {

        }
        $this->assertEquals(1, count($targetArray), 'Метод delete не работает');
    }

    /**
     * @test
     * @dataProvider providerUpdate
     * @param $assertion
     * @param array $targetArray
     */
    public function checkUpdateMethod($assertion, array $targetArray)
    {
        $this->assertContains($assertion, $targetArray, 'не работат метод Update');
    }

    public function providerUpdate()
    {
        $targetArray = [];
        try {
            $userTable = new UserTableWrapper();
            $userTable->insert(array(1, 'Totoshka', 'Rastotoshka', 'ararara@gmail.com'));
            $userTable->update(1, array(4, "Toto", "Rast", "arara@sda.com"));
            $targetArray = $userTable->get()[1];
        } catch (Exception $e) {
            // незнаю как бросить ошибку теста здесь
        }
        return array(
            array(4, $targetArray),
            array('Toto', $targetArray),
            array('Rast', $targetArray),
            array('arara@sda.com', $targetArray)
        );
    }

}