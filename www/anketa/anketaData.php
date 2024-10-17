
<h1 class="font-montserrat font-semibold text-black text-4xl">Моя анкета</h1>
<div class="flex flex-col gap-3">

    <div class="inputRow">
        <p class="capitalize text-right">
            ФИО
        </p>
        <p><?= $arr["FIO"]["VALUE"] ?></p>
    </div>

    <div class="inputRow">
        <p class="capitalize text-right">
            Специальность
        </p>

        <p><?= $arr["SPEC"]["VALUE"] ?></p>
    </div>
    <div class="inputRow">
        <p class="capitalize text-right">
            образование
        </p>
        <p><?= $arr["PROF"]["VALUE"] ?></p>
    </div>
    <div class="inputRow">
        <p class="capitalize text-right">
            опыт работы в годах
        </p>
        <p><?= $arr["WORK_YEARS"]["VALUE"] ?></p>
    </div>

    <div class="inputRow items-start">
        <p class="capitalize text-right">
            инструменты
        </p>

        <div>
            <? foreach ($arr["TOOLS"]["VALUE"] as $item): ?>
                <p><?= $item ?></p>
            <? endforeach; ?>
        </div>
    </div>
    <div class="inputRow">
        <p class="capitalize text-right">
            работа с электрикой
        </p>
        <p><?= $arr["ELECTR"]["VALUE"] ?></p>
    </div>
    <div class="inputRow">
        <p class="capitalize text-right">
            работа с сантехникой
        </p>
        <p><?= $arr["SANT"]["VALUE"] ?></p>
    </div>
    <div class="inputRow">
        <p class="capitalize text-right">
            еврозапил
        </p>
        <p><?= $arr["EVROAZAP"]["VALUE"] ?></p>
    </div>
    <div class="inputRow">
        <p class="capitalize text-right">
            Реставрация
        </p>
        <p><?= $arr["RESTOR"]["VALUE"] ?></p>
    </div>
    <div class="inputRow">
        <p class="capitalize text-right">
            работа с камнем (акрил, кварц)
        </p>
        <p><?= $arr["ROCK_WORK"]["VALUE"] ?></p>
    </div>
    <div class="inputRow fullGrid items-start ">
        <p class="capitalize text-right">
            Фото примеров работ
        </p>
        <div id="images" style="display: flex">
            <? foreach ($arr["GALLERY"]["VALUE"] as $item): ?>
                <img src="<?= CFile::GetPath($item) ?>" >
            <? endforeach; ?>
        </div>
    </div>
    <div class="inputRow">
        <p class="capitalize text-right">
            работа с карнизами (высокими)
        </p>
        <p><?= $arr["COR_WORK"]["VALUE"] ?></p>
    </div>
    <div class="inputRow">
        <p class="capitalize text-right">
            с напарником или без
        </p>
        <p><?= $arr["COMRAD"]["VALUE"] ?></p>
    </div>
    <div class="inputRow">
        <p class="capitalize text-right">
            гражданство
        </p>
        <p><?= $arr["CIT"]["VALUE"] ?></p>
    </div>
    <div class="inputRow">
        <p class="capitalize text-right">
            пол
        </p>
        <p><?= $arr["GEN"]["VALUE"] ?></p>

    </div>

</div>