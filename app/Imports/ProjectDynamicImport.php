<?php

namespace App\Imports;

use App\Factory\ProjectDynamicFactory;
use App\Factory\ProjectFactory;
use App\Models\FailedRow;
use App\Models\Payment;
use App\Models\Project;
use App\Models\Task;
use App\Models\Type;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Events\BeforeSheet;
use Maatwebsite\Excel\Validators\Failure;

class ProjectDynamicImport implements ToCollection, WithValidation, SkipsOnFailure, WithStartRow, WithEvents
{

    use RegistersEventListeners;
    /**
     * @param Collection $collection
     */
    private Task $task;
    private static array $headings;
    const STATIC_ROW = 12;

    /**
     * @param $task
     */
    public function __construct($task)
    {
        $this->task = $task;
    }


    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        $typesMap = $this->getTypesMap(Type::all());


        foreach ($collection as $row) {
            if (!isset($row[1])) {
                continue;
            }

            $map = $this->getTypesMap($row);
            $projectFactory = ProjectDynamicFactory::make($typesMap, $map['static']);

            $project = Project::updateOrCreate([
                'type_id' => $projectFactory->getValues()['type_id'],
                'title' => $projectFactory->getValues()['title'],
                'created_at_time' => $projectFactory->getValues()['created_at_time'],
                'contracted_at' => $projectFactory->getValues()['contracted_at'],
            ], $projectFactory->getValues());

            if (isset($map['dynamic'])) continue;

            $dynamicHeadings = $this->getRowsMap(self::$headings)['dynamic'];

            foreach ($map['dynamic'] as $key => $item) {
                Payment::created([
                    'project_id' => $project->id,
                    'title' => $dynamicHeadings[$key],
                    'value' => $item,
                ]);
            }
        }
    }

    private function getTypesMap($types): array
    {
        $map = [];
        foreach ($types as $type) {
            $map[$type->title] = $type->id;
        }

        return $map;
    }
//    private function getTypesMap($types): array
//    {
//        $map = [];
//
//        foreach ($types as $type) {
//            if (!is_object($type)) {
//                dd("Ошибка: в getTypesMap() переданы строки вместо объектов.", $types);
//            }
//
//            $map[$type->title] = $type->id;
//        }
//
//        return $map;
//    }

    public function getRowsMap($row)
    {
        $static = [];
        $dynamic = [];
        foreach ($row as $key => $value) {
            if ($value) {
                $key > 12 ? $dynamic[$key] = $value : $static[$key] = $value;
            }
        }

        return [
            'static' => $static,
            'dynamic' => $dynamic,
        ];
    }

    public function rules(): array
    {
        return array_replace([
            '0' => 'required|string',
            '1' => 'required|string',
            '2' => 'required|integer',
            '9' => 'required|integer',
            '7' => 'nullable|integer',
            '3' => 'nullable|string',
            '5' => 'nullable|string',
            '6' => 'nullable|string',
            '8' => 'nullable|string',
            '4' => 'nullable|integer',
            '10' => 'nullable|integer',
            '11' => 'nullable|string',
            '12' => 'nullable|numeric',
        ], $this->getDynamicValidation());
    }

    public function onFailure(Failure ...$failures)
    {
        processFailures($failures, $this->attributesMap(), $this->task);
    }

    private function attributesMap(): array
    {
        return array_replace([
            '0' => 'Тип',
            '1' => 'Наименование',
            '2' => 'Дата создания',
            '9' => 'Подписание договора',
            '7' => 'Дедлайн',
            '3' => 'Сетевик',
            '5' => 'Наличие аутсорсинга',
            '6' => 'Наличие инвесторов',
            '8' => 'Сдача в срок',
            '4' => 'Количество участников',
            '10' => 'Количество услуг',
            '11' => 'Комментарий',
            '12' => 'Значение эффективности',
        ], $this->getRowsMap(self::$headings)['dynamic']);
    }

    public function startRow(): int
    {
        return 2;
    }

    public static function beforeSheet(BeforeSheet $event)
    {
       self::$headings = $event->getSheet()->getDelegate()->toArray()[0];
    }

    private function getDynamicValidation(): array
    {
        $headers = $this->getRowsMap(self::$headings)['dynamic'];
        foreach ($headers as $key => $value) {
            $headers[$key] = 'required|integer';
        }

        return $headers;
    }

}
