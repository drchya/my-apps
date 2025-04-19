<!-- partials/datepicker-popup.blade.php -->
<div
    x-show="open"
    class="absolute z-10 mt-2 w-72 bg-gray-900 border border-gray-800 rounded-lg shadow-lg p-4"
    @click.away="open = false"
    x-transition
>
    <div class="flex justify-between items-center mb-4">
        <span @click="prevMonth()" class="text-gray-500 hover:text-gray-300 cursor-pointer transition">&lt;</span>
        <div class="text-lg font-semibold text-gray-500" x-text="monthNames[month] + ' ' + year"></div>
        <span @click="nextMonth()" class="text-gray-500 hover:text-gray-300 cursor-pointer transition">&gt;</span>
    </div>

    <div class="grid grid-cols-7 text-center text-sm font-medium text-gray-500 mb-2">
        <template x-for="day in ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab']">
            <div x-text="day"></div>
        </template>
    </div>

    <div class="grid grid-cols-7 gap-1 text-center">
        <template x-for="blank in blanks"><div></div></template>

        <template x-for="(date, index) in daysInMonth" :key="index">
            <div
                @click="selectDate(date)"
                x-text="date"
                :class="{
                    'border border-emerald-500 text-white': isToday(date),
                    'hover:bg-gray-800 cursor-pointer rounded-md transition': true,
                    'bg-emerald-500 text-white': isSelectedDate(date)
                }"
                class="py-1"
            ></div>
        </template>
    </div>
</div>
