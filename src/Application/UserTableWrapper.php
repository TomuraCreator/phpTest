<?php declare(strict_types=1);
namespace Application;
use \Interfaces\TableWrapperInterface;

class UserTableWrapper implements TableWrapperInterface
{
    private array $table = array(array('id', 'name', 'surname', 'email'));

    /**
     * @param int $id
     * @throws \Exception
     */
    public function delete(int $id): void
    {
        if($id === 0) throw new \Exception('Нельзя удалить заголовки!');
        $table = $this->table;
        $filterArray = array_filter($table, function($index) use ($id, $table) {

            if(in_array($id, $table[$index])) {
                unset($this->table[$index]);
                return true;
            } else {
                return false;
            }
        }, ARRAY_FILTER_USE_KEY);
        if(!count($filterArray)) throw new \Exception("id с номером '$id' не существует");
    }

    /**
     * @return array|\string[][]
     */
    public function get(): array
    {
        return $this->table;
    }

    /**
     * @param array $values
     * @throws \Exception
     */
    public function insert(array $values): void
    {
        if($this->typeValidate($values)) {
            $this->table[] = $values;
        }

    }

    /**
     * @param int $id
     * @param array $values
     * @return array
     * @throws \Exception
     */
    public function update(int $id, array $values): array
    {
        $table = $this->get();
        if($this->typeValidate($values)) {
            foreach ($table as $key=>$value) {
                if($value[0] === $id) {
                    $this->table[$key] = $values;
                    return $this->table[$key];
                }
            }
        }
    }

    /**
     * type values validate
     * @private
     * @param array $values
     * @return bool
     * @throws \Exception
     */

    private function typeValidate(array $values) : bool
    {
        $table = $this->get();
        if(!count($values)) throw new \Exception('Массив аргументов пуст');
        if(count($values) > 4) throw new \Exception('Аргументов более 4х');

        for($i=1; $i < count($values); $i++) {
            if($i === 0 && gettype($values[$i]) !== "number") {
                throw new \Exception("Тип аргумента $table[$i] не 'number'");
            }
            if($i !== 0 && gettype($values[$i]) !== "string") {
                throw new \Exception("Тип аргумента $table[$i] не 'string'");
            }
        }
        return true;
    }
}
