# Benchmark Command

    php artisan push 1 100000 0 & php artisan push 100001 200000 0 & php artisan pop 50000 & php artisan pop 50000 & php artisan pop 50000 & php artisan pop 50000

2 push jobs, each push 100k distinct jobs into the :delayed queue. There are 4 pop jobs, each of them pop 50k job off the queue.

# Results

## Definitions

- last_push: the time it takes a push command to push all the (100K) jobs.
- last_pop: the time it takes a pop command to pop all the (50K) jobs.
- pop_exception: an exception thrown during pop.
- push_exception: an exception thrown during push.
- stall of a pop_exception: the time passed after the last successful pop (or the start of the test if there is no successful pop at all).

## Results on my Vostro 1520 (Core 2 Due: 2 cpu cores)

Measure|Laravel 5.2 driver (Check&Set Transactions)|Proposed driver (Exec Transactions)|Improvement
-------|-------------------------------------------|-----------------------------------|-----------
max(last_push) among all pushers|92.918915987015|62.77826499939|1.48x faster
max(last_pop) among all workers|182.98471593857|71.986850976944|2.54x faster
number of pop_exceptions (AbortedMultiExecException)|55|0|no exception at all
number of push_exceptions|0|0|any
max(pop_stall) among all workers|92.499501943588|non|no stall at all

## Results on my work PC (core i5: 4 cpu cores)

Measure|Laravel 5.2 driver (Check&Set Transactions)|Proposed driver (Exec Transactions)|Improvement
-------|-------------------------------------------|-----------------------------------|-----------
last_push|54 seconds|21 seconds|2.5x faster
last_pop|88 seconds|24 seconds|3.6x faster
pop_exceptions (AbortedMultiExecException)|64 times|0|No exception
push_exceptions|0|0| non
