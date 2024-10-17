<?php
use Adamcode\Config\Blocks;
?>
<h1 class="font-montserrat font-semibold text-black text-4xl">Анкета</h1>
<div class="appForm">

    <div class="inputRow">
        <p class="capitalize text-right">
            ФИО
        </p>
        <div class="h-12 border rounded-md overflow-hidden bg-white ">
            <input class="border-none h-full outline-none w-full pt-[0.75rem] pr-4 pl-4 pb-4" type="text" data-input="FIO" placeholder="ФИО">
        </div>
    </div>

    <div class="inputRow">
        <p class="capitalize text-right">
            Специальность
        </p>

        <div class="min-w-28 h-full">
            <div class="bg-white border rounded-md h-full pt-2 pr-3 pl-3 pb-3 relative" data-select="select">
                <div class="flex gap-2 justify-center items-center cursor-pointer" listinput="">
                    <p class="SPEC font-montserrat font-semibold text-base w-calc-input" data-value="">Выберите специальность</p><img class="w-5 h-5 object-contain transition-all" src="/local/templates/furnitureAssembly/img/icons/CaretDown.svg" list-btn="" alt="Иконка">
                </div>
                <div class="flex flex-col gap-2 absolute bg-white left-0 w-full overflow-hidden top-full shadow-md z-50 h-0" list="">

                    <?
                    $i = false;
                    $property_enums = CIBlockPropertyEnum::GetList(Array("DEF"=>"DESC", "SORT"=>"ASC"), Array("IBLOCK_ID"=>Blocks::anceti->value, "CODE"=>"SPEC"));
                    while($enum_fields = $property_enums->GetNext())
                    {
                        $checked = "";
                        if($i == false){
                            $checked = "checked";
                        }
                        $i = true;
                        ?>

                        <div class="px-3 cursor-pointer pb-2" data-value="<?= $enum_fields["ID"] ?>">
                            <p class="font-montserrat font-semibold text-base" selectVal="<?= $enum_fields["ID"] ?>"><?= $enum_fields["VALUE"] ?></p>
                            <p class="font-montserrat font-semibold text-base text-gray-400"></p>
                        </div>

                        <?
                    }
                    ?>

                </div>
            </div>
        </div>
    </div>
    <div class="inputRow">
        <p class="capitalize text-right">
            образование
        </p>
        <div class="h-12 border rounded-md overflow-hidden bg-white ">
            <input class="border-none h-full outline-none w-full pt-[0.75rem] pr-4 pl-4 pb-4" type="text" data-input="PROF" placeholder="образование">
        </div>
    </div>
    <div class="inputRow">
        <p class="capitalize text-right">
            опыт работы в годах
        </p>
        <div class="h-12 border rounded-md overflow-hidden bg-white ">
            <input class="border-none h-full outline-none w-full pt-[0.75rem] pr-4 pl-4 pb-4" type="text" data-input="WORK_YEARS" placeholder="опыт работы в годах">
        </div>
    </div>

    <div class="inputRow items-start">
        <p class="capitalize text-right">
            инструменты
        </p>

        <div class="flex flex-col gap-1">
            <?

            $property_enums = CIBlockPropertyEnum::GetList(Array("DEF"=>"DESC", "SORT"=>"ASC"), Array("IBLOCK_ID"=>Blocks::anceti->value, "CODE"=>"TOOLS"));
            while($enum_fields = $property_enums->GetNext())
            {
                ?>

                <label class="checkRow flex items-center gap-2">

                    <label class="relative inline-block w-4 h-4">
                        <input data-list="TOOLS" value="<?= $enum_fields["ID"] ?>" class="opacity-0 w-0 h-0 peer" type="checkbox" name="checkbox6"/><span class="absolute cursor-pointer top-0 left-0 right-0 bottom-0 bg-gray-300 transition-all duration-400 rounded-sm peer-focus:ring peer-focus:ring-primary peer-focus:ring-opacity-50"></span><span class="absolute top-0 left-0 cursor-pointer w-full h-full hidden peer-checked:flex peer-checked:items-center peer-checked:justify-center">
                  <svg class="w-3 h-3" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M28.7074 9.70751L12.7074 25.7075C12.6146 25.8005 12.5043 25.8742 12.3829 25.9246C12.2615 25.9749 12.1314 26.0008 11.9999 26.0008C11.8685 26.0008 11.7384 25.9749 11.617 25.9246C11.4956 25.8742 11.3853 25.8005 11.2924 25.7075L4.29245 18.7075C4.1048 18.5199 3.99939 18.2654 3.99939 18C3.99939 17.7346 4.1048 17.4801 4.29245 17.2925C4.48009 17.1049 4.73458 16.9994 4.99995 16.9994C5.26531 16.9994 5.5198 17.1049 5.70745 17.2925L11.9999 23.5863L27.2924 8.29251C27.4801 8.10487 27.7346 7.99945 27.9999 7.99945C28.2653 7.99945 28.5198 8.10487 28.7074 8.29251C28.8951 8.48015 29.0005 8.73464 29.0005 9.00001C29.0005 9.26537 28.8951 9.51987 28.7074 9.70751Z" fill="#a27dfa" stroke="#a27dfa" stroke-width="4"></path>
                  </svg></span>
                    </label>
                    <p><?= $enum_fields["VALUE"] ?></p>
                </label>

                <?
            }
            ?>


        </div>
    </div>
    <div class="inputRow">
        <p class="capitalize text-right">
            работа с электрикой
        </p>
        <label class="relative inline-block w-4 h-4">
            <input data-check="ELECTR" class="opacity-0 w-0 h-0 peer" type="checkbox" name="checkbox6"/><span class="absolute cursor-pointer top-0 left-0 right-0 bottom-0 bg-gray-300 transition-all duration-400 rounded-sm peer-focus:ring peer-focus:ring-primary peer-focus:ring-opacity-50"></span><span class="absolute top-0 left-0 cursor-pointer w-full h-full hidden peer-checked:flex peer-checked:items-center peer-checked:justify-center">
                  <svg class="w-3 h-3" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M28.7074 9.70751L12.7074 25.7075C12.6146 25.8005 12.5043 25.8742 12.3829 25.9246C12.2615 25.9749 12.1314 26.0008 11.9999 26.0008C11.8685 26.0008 11.7384 25.9749 11.617 25.9246C11.4956 25.8742 11.3853 25.8005 11.2924 25.7075L4.29245 18.7075C4.1048 18.5199 3.99939 18.2654 3.99939 18C3.99939 17.7346 4.1048 17.4801 4.29245 17.2925C4.48009 17.1049 4.73458 16.9994 4.99995 16.9994C5.26531 16.9994 5.5198 17.1049 5.70745 17.2925L11.9999 23.5863L27.2924 8.29251C27.4801 8.10487 27.7346 7.99945 27.9999 7.99945C28.2653 7.99945 28.5198 8.10487 28.7074 8.29251C28.8951 8.48015 29.0005 8.73464 29.0005 9.00001C29.0005 9.26537 28.8951 9.51987 28.7074 9.70751Z" fill="#a27dfa" stroke="#a27dfa" stroke-width="4"></path>
                  </svg></span>
        </label>
    </div>
    <div class="inputRow">
        <p class="capitalize text-right">
            работа с сантехникой
        </p>
        <label class="relative inline-block w-4 h-4">
            <input data-check="SANT" class="opacity-0 w-0 h-0 peer" type="checkbox" name="checkbox5"/><span class="absolute cursor-pointer top-0 left-0 right-0 bottom-0 bg-gray-300 transition-all duration-400 rounded-sm peer-focus:ring peer-focus:ring-primary peer-focus:ring-opacity-50"></span><span class="absolute top-0 left-0 cursor-pointer w-full h-full hidden peer-checked:flex peer-checked:items-center peer-checked:justify-center">
                  <svg class="w-3 h-3" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M28.7074 9.70751L12.7074 25.7075C12.6146 25.8005 12.5043 25.8742 12.3829 25.9246C12.2615 25.9749 12.1314 26.0008 11.9999 26.0008C11.8685 26.0008 11.7384 25.9749 11.617 25.9246C11.4956 25.8742 11.3853 25.8005 11.2924 25.7075L4.29245 18.7075C4.1048 18.5199 3.99939 18.2654 3.99939 18C3.99939 17.7346 4.1048 17.4801 4.29245 17.2925C4.48009 17.1049 4.73458 16.9994 4.99995 16.9994C5.26531 16.9994 5.5198 17.1049 5.70745 17.2925L11.9999 23.5863L27.2924 8.29251C27.4801 8.10487 27.7346 7.99945 27.9999 7.99945C28.2653 7.99945 28.5198 8.10487 28.7074 8.29251C28.8951 8.48015 29.0005 8.73464 29.0005 9.00001C29.0005 9.26537 28.8951 9.51987 28.7074 9.70751Z" fill="#a27dfa" stroke="#a27dfa" stroke-width="4"></path>
                  </svg></span>
        </label>
    </div>
    <div class="inputRow">
        <p class="capitalize text-right">
            еврозапил
        </p>
        <label class="relative inline-block w-4 h-4">
            <input data-check="EVROAZAP" class="opacity-0 w-0 h-0 peer" type="checkbox" name="checkbox4"/><span class="absolute cursor-pointer top-0 left-0 right-0 bottom-0 bg-gray-300 transition-all duration-400 rounded-sm peer-focus:ring peer-focus:ring-primary peer-focus:ring-opacity-50"></span><span class="absolute top-0 left-0 cursor-pointer w-full h-full hidden peer-checked:flex peer-checked:items-center peer-checked:justify-center">
                  <svg class="w-3 h-3" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M28.7074 9.70751L12.7074 25.7075C12.6146 25.8005 12.5043 25.8742 12.3829 25.9246C12.2615 25.9749 12.1314 26.0008 11.9999 26.0008C11.8685 26.0008 11.7384 25.9749 11.617 25.9246C11.4956 25.8742 11.3853 25.8005 11.2924 25.7075L4.29245 18.7075C4.1048 18.5199 3.99939 18.2654 3.99939 18C3.99939 17.7346 4.1048 17.4801 4.29245 17.2925C4.48009 17.1049 4.73458 16.9994 4.99995 16.9994C5.26531 16.9994 5.5198 17.1049 5.70745 17.2925L11.9999 23.5863L27.2924 8.29251C27.4801 8.10487 27.7346 7.99945 27.9999 7.99945C28.2653 7.99945 28.5198 8.10487 28.7074 8.29251C28.8951 8.48015 29.0005 8.73464 29.0005 9.00001C29.0005 9.26537 28.8951 9.51987 28.7074 9.70751Z" fill="#a27dfa" stroke="#a27dfa" stroke-width="4"></path>
                  </svg></span>
        </label>
    </div>
    <div class="inputRow">
        <p class="capitalize text-right">
            Реставрация
        </p>
        <label class="relative inline-block w-4 h-4">
            <input data-check="RESTOR" class="opacity-0 w-0 h-0 peer" type="checkbox" name="checkbox3"/><span class="absolute cursor-pointer top-0 left-0 right-0 bottom-0 bg-gray-300 transition-all duration-400 rounded-sm peer-focus:ring peer-focus:ring-primary peer-focus:ring-opacity-50"></span><span class="absolute top-0 left-0 cursor-pointer w-full h-full hidden peer-checked:flex peer-checked:items-center peer-checked:justify-center">
                  <svg class="w-3 h-3" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M28.7074 9.70751L12.7074 25.7075C12.6146 25.8005 12.5043 25.8742 12.3829 25.9246C12.2615 25.9749 12.1314 26.0008 11.9999 26.0008C11.8685 26.0008 11.7384 25.9749 11.617 25.9246C11.4956 25.8742 11.3853 25.8005 11.2924 25.7075L4.29245 18.7075C4.1048 18.5199 3.99939 18.2654 3.99939 18C3.99939 17.7346 4.1048 17.4801 4.29245 17.2925C4.48009 17.1049 4.73458 16.9994 4.99995 16.9994C5.26531 16.9994 5.5198 17.1049 5.70745 17.2925L11.9999 23.5863L27.2924 8.29251C27.4801 8.10487 27.7346 7.99945 27.9999 7.99945C28.2653 7.99945 28.5198 8.10487 28.7074 8.29251C28.8951 8.48015 29.0005 8.73464 29.0005 9.00001C29.0005 9.26537 28.8951 9.51987 28.7074 9.70751Z" fill="#a27dfa" stroke="#a27dfa" stroke-width="4"></path>
                  </svg></span>
        </label>
    </div>
    <div class="inputRow">
        <p class="capitalize text-right">
            работа с камнем (акрил, кварц)
        </p>
        <label class="relative inline-block w-4 h-4">
            <input data-check="ROCK_WORK" class="opacity-0 w-0 h-0 peer" type="checkbox" name="checkbox2"/><span class="absolute cursor-pointer top-0 left-0 right-0 bottom-0 bg-gray-300 transition-all duration-400 rounded-sm peer-focus:ring peer-focus:ring-primary peer-focus:ring-opacity-50"></span><span class="absolute top-0 left-0 cursor-pointer w-full h-full hidden peer-checked:flex peer-checked:items-center peer-checked:justify-center">
                  <svg class="w-3 h-3" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M28.7074 9.70751L12.7074 25.7075C12.6146 25.8005 12.5043 25.8742 12.3829 25.9246C12.2615 25.9749 12.1314 26.0008 11.9999 26.0008C11.8685 26.0008 11.7384 25.9749 11.617 25.9246C11.4956 25.8742 11.3853 25.8005 11.2924 25.7075L4.29245 18.7075C4.1048 18.5199 3.99939 18.2654 3.99939 18C3.99939 17.7346 4.1048 17.4801 4.29245 17.2925C4.48009 17.1049 4.73458 16.9994 4.99995 16.9994C5.26531 16.9994 5.5198 17.1049 5.70745 17.2925L11.9999 23.5863L27.2924 8.29251C27.4801 8.10487 27.7346 7.99945 27.9999 7.99945C28.2653 7.99945 28.5198 8.10487 28.7074 8.29251C28.8951 8.48015 29.0005 8.73464 29.0005 9.00001C29.0005 9.26537 28.8951 9.51987 28.7074 9.70751Z" fill="#a27dfa" stroke="#a27dfa" stroke-width="4"></path>
                  </svg></span>
        </label>
    </div>
    <div class="inputRow fullGrid items-start ">
        <p class="capitalize text-right">
            Фото примеров работ
        </p>
        <div class="flex flex-col">
            <label class="flex gap-2 font-montserrat font-semibold cursor-pointer hover:text-primary">Прикрепить файл<img class="w-6 h-6 object-contain" src="/local/templates/furnitureAssembly/img/icons/Paperclip.svg" alt="иконка"/>
                <input data-gal="GALLERY" class="hidden photo" multiple="multiple"  type="file" name="file[]"  data-file="file1"/>
            </label>
            <div id="images"></div>
        </div>


    </div>
    <div class="inputRow">
        <p class="capitalize text-right">
            работа с карнизами (высокими)
        </p>
        <label class="relative inline-block w-4 h-4">
            <input data-check="COR_WORK" class="opacity-0 w-0 h-0 peer" type="checkbox" name="checkbox1"/><span class="absolute cursor-pointer top-0 left-0 right-0 bottom-0 bg-gray-300 transition-all duration-400 rounded-sm peer-focus:ring peer-focus:ring-primary peer-focus:ring-opacity-50"></span><span class="absolute top-0 left-0 cursor-pointer w-full h-full hidden peer-checked:flex peer-checked:items-center peer-checked:justify-center">
                  <svg class="w-3 h-3" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M28.7074 9.70751L12.7074 25.7075C12.6146 25.8005 12.5043 25.8742 12.3829 25.9246C12.2615 25.9749 12.1314 26.0008 11.9999 26.0008C11.8685 26.0008 11.7384 25.9749 11.617 25.9246C11.4956 25.8742 11.3853 25.8005 11.2924 25.7075L4.29245 18.7075C4.1048 18.5199 3.99939 18.2654 3.99939 18C3.99939 17.7346 4.1048 17.4801 4.29245 17.2925C4.48009 17.1049 4.73458 16.9994 4.99995 16.9994C5.26531 16.9994 5.5198 17.1049 5.70745 17.2925L11.9999 23.5863L27.2924 8.29251C27.4801 8.10487 27.7346 7.99945 27.9999 7.99945C28.2653 7.99945 28.5198 8.10487 28.7074 8.29251C28.8951 8.48015 29.0005 8.73464 29.0005 9.00001C29.0005 9.26537 28.8951 9.51987 28.7074 9.70751Z" fill="#a27dfa" stroke="#a27dfa" stroke-width="4"></path>
                  </svg></span>
        </label>
    </div>
    <div class="inputRow">
        <p class="capitalize text-right">
            с напарником или без
        </p>
        <div class="flex items-center gap-3">
            <label class="checkRow flex items-center gap-2">
                <p>С напарником</p>
                <label for="radio4" class="relative inline-block w-4 h-4">
                    <input data-check="COMRAD" value="yes" class="opacity-0 w-0 h-0 peer" checked type="radio" id="radio4" name="comrade"/><span class="absolute cursor-pointer top-0 left-0 right-0 bottom-0 bg-gray-300 transition-all duration-400 rounded-full peer-focus:ring peer-focus:ring-primary peer-focus:ring-opacity-50"></span><span class="absolute cursor-pointer w-full h-full peer-checked:border-primary peer-checked:border-4 peer-checked:rounded-full"></span>
                </label>
            </label>
            <label class="checkRow flex items-center gap-2">
                <p>Без напарника</p>
                <label for="radio3" class="relative inline-block w-4 h-4">
                    <input data-check="COMRAD" value="no" class="opacity-0 w-0 h-0 peer"  type="radio" id="radio3" name="comrade"/><span class="absolute cursor-pointer top-0 left-0 right-0 bottom-0 bg-gray-300 transition-all duration-400 rounded-full peer-focus:ring peer-focus:ring-primary peer-focus:ring-opacity-50"></span><span class="absolute cursor-pointer w-full h-full peer-checked:border-primary peer-checked:border-4 peer-checked:rounded-full"></span>
                </label>
            </label>

        </div>
    </div>
    <div class="inputRow">
        <p class="capitalize text-right">
            гражданство
        </p>
        <div class="h-12 border rounded-md overflow-hidden bg-white ">
            <input data-input="CIT" class="border-none h-full outline-none w-full pt-[0.75rem] pr-4 pl-4 pb-4" type="text" data-input="CIT" placeholder="гражданство">
        </div>
    </div>
    <div class="inputRow">
        <p class="capitalize text-right">
            пол
        </p>
        <div class="flex items-center gap-3">

            <?
            $i = false;
            $property_enums = CIBlockPropertyEnum::GetList(Array("DEF"=>"DESC", "SORT"=>"ASC"), Array("IBLOCK_ID"=>Blocks::anceti->value, "CODE"=>"GEN"));
            while($enum_fields = $property_enums->GetNext())
            {
                $checked = "";
                if($i == false){
                    $checked = "checked";
                }
                $i = true;
                ?>

                <label class="checkRow flex items-center gap-2">
                    <p><?= $enum_fields["VALUE"] ?></p>
                    <label for="radio<?= $enum_fields["ID"] ?>" class="relative inline-block w-4 h-4">
                        <input data-check="GEN" value="<?= $enum_fields["ID"] ?>" class="opacity-0 w-0 h-0 peer" <?= $checked ?> type="radio" id="radio<?= $enum_fields["ID"] ?>" name="pol"/>
                        <span class="absolute cursor-pointer top-0 left-0 right-0 bottom-0 bg-gray-300 transition-all duration-400 rounded-full peer-focus:ring peer-focus:ring-primary peer-focus:ring-opacity-50"></span>
                        <span class="absolute cursor-pointer w-full h-full peer-checked:border-primary peer-checked:border-4 peer-checked:rounded-full"></span>
                    </label>
                </label>
                <?
            }
            ?>

        </div>

    </div>
    <button class="flex gap-2 font-montserrat font-semibold text-base px-4 py-2 rounded-full border-[#FFFFFF] text-[#fff] bg-primary w-max" data-btn="send">Отправить
    </button>
</div>