<?

namespace Adamcode\Services;
use Bitrix\Main\Type\Date;

use Adamcode\Models\Employee;
use Adamcode\Util\EmployeeUtils;
use DateTime;
class BirthdayService
{
	private array $months = ['01' => "Январь", '02' => "Февраль", '03' => 'Март', '04' => 'Апрель', '05' => 'Май', '06' => 'Июнь', '07' => 'Июль', '08' => 'Август', '09' => 'Сентябрь', 10 => 'Октябрь', 11 => 'Ноябрь', 12 => 'Декабрь'];
	private array $birth = [];

	public function getMonths(): array
	{
		return $this->months;
	}

	private function isTodayBirthday($birthday) {

		$today = new DateTime();
		$birthdayDate = new DateTime($birthday);
//                                        echo '<pre>';
//                                print_r($today->format('m-d') . "   " . $birthdayDate->format('m-d'));
//                                echo '</pre>';
		return $today->format('m-d') == $birthdayDate->format('m-d');
	}
	private function prepareArr()
	{
		foreach ($this->birth as $key => $birth)
		{
			$emp = new EmployeeUtils($birth["ID"]);
			$this->birth[$key]["PHOTO"] = $emp->get_info()["PHOTO"];
			$this->birth[$key]["CAN_CONGRAT"] = $this->isTodayBirthday($birth["PROPERTY_DATE_VALUE"]);

		}
		return $this->groupItemsByDate();
	}

	public function groupItemsByDate() {

		$groupedItems = ["Январь" => [], "Февраль" => [], 'Март' => [], 'Апрель' => [], 'Май' => [], 'Июнь' => [], 'Июль' => [], 'Август' => [], 'Сентябрь' => [], 'Октябрь' => [], 'Ноябрь' => [], 'Декабрь' => []];
		foreach (	$this->birth as $item) {
            if($item['PROPERTY_DATE_VALUE'] == ""){
                continue;
            }
			$date = $item['PROPERTY_DATE_VALUE'];
			$formattedDate =$this->months[date('m', strtotime($date))];

			$groupedItems[$formattedDate][] = $item;

		}
//                                                echo '<pre>';
//                                print_r($groupedItems);
//                                echo '</pre>';
        $this->birth=$groupedItems;
        foreach ($groupedItems as $key => $groupedItem) {
            if($groupedItem == []){
                unset($groupedItems[$key]);
            }
        }
		return $groupedItems;
	}
	public function filterByMounth ($mounth) {
		$monthName = $this->getMonths()[$mounth];
		$birth=!empty($this->birth[$monthName])?$this->birth[$monthName]:[];
		return [$monthName => $birth];
	}
	public  function filterEmployeesByDateRange($direction): array
	{

        $nextDate = strtotime(Date('d.m.2000', strtotime('+7 days')));
        $prevDate = strtotime(Date('d.m.2000', strtotime('-2 days')));

        $prevDateNext = strtotime(Date('d.m.2000', strtotime('-7 days')));

        $today = strtotime(Date('d.m.2000'));
		$filteredEmployees = [];

		foreach ($this->birth as $month => $employeesOfMonth)
		{

			foreach ($employeesOfMonth as $employee)

			{
                if($employee['PROPERTY_DATE_VALUE'] == ""){
                    continue;
                }

				$employeeDate = strtotime($employee['PROPERTY_DATE_VALUE']);
                $employeeDate =  Date('d.m.2000', $employeeDate);
                $employeeDate = strtotime($employeeDate);
				if ($direction === 'previous')
                {


                    if ($employeeDate >= $prevDateNext && $employeeDate <= $today)
                    {

                        $filteredEmployees[$month][] = $employee;

                    }
                }
				elseif ($direction === 'next')
				{


//                    if ($employeeDate >= $prevDate && $employeeDate <= $nextDate)
                    if ($employeeDate >= $today && $employeeDate <= $nextDate)
					{

						$filteredEmployees[$month][] = $employee;

					}
				}
			}

		}

		return $filteredEmployees;
	}

	public  function getEmployeeBirthdaysList( $month,$departmentId = null,$fromToday = null) {

		$filter = ["!PROPERTY_SHOW_BIRT_VALUE"=>false];
		if ($fromToday || $month != null) {
			$day= new DateTime("now");

			$day = $fromToday ? $day->format("d") : '01';
			$startDate = new DateTime(date("2000-{$month}-{$day}"));
			$endDate = new DateTime(date("2000-{$month}-t"));
			$filter['>=PROPERTY_SORT_DATE_VALUE']=$startDate->format('Y-m-d');
			$filter['<=PROPERTY_SORT_DATE_VALUE']=$endDate->format('Y-m-d');
            $filter['!=PROPERTY_DATE_VALUE']="";
		}
		if ($departmentId !== null) {
			$filter['SECTION_ID'] = $departmentId;
		}
		else{
			$filter['INCLUDE_SUBSECTIONS'] = "Y";
		}
			$birthArr = Employee::query()->active()->select(["ID", "DETAIL_PAGE_URL","NAME","PROPERTY_SORT_DATE","PROPERTY_EMAIL","PROPERTY_POSITION","PROPERTY_DATE"])->filter($filter)->sort(["PROPERTY_SORT_DATE" => "ASC"])->getList()->toArray();

//                                        echo '<pre>';
//                                print_r($birthArr);
//                                echo '</pre>';

		$this->birth=$birthArr;
		return $this->prepareArr();
	}




}