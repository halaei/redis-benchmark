# Benchmark Command

    php artisan push 1 100000 0 & php artisan push 100001 200000 0 & php artisan pop 50000 & php artisan pop 50000 & php artisan pop 50000 & php artisan pop 50000

# Results


Measure|Laravel 5.2 driver (Check&Set Transactions)|Proposed driver (Exec Transactions)|Improvement
-------|-------------------------------------------|-----------------------------------|-----------
last_push|54 seconds|21 seconds|2.5x faster
last_pop|88 seconds|24 seconds|3.6x faster
pop_exceptions (AbortedMultiExecException)|64 times|0|No exception
push_exceptions|0|0| non
