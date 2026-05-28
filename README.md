## Things to do

- User/Admin authorized routes and actions (middleware if necessary) DONE (Still something to do)
- Pagination and A little design (also need to do navigation accessibility using maybe breadcumb)
- (Must) Creator/Admin can change the status of task

- Replace hardcoded value to {{__('...')__}} like (because anyone can change)
- Learn every detail (like every detail in Jetstream), don't repeat code ( use component layout ) and minimize code in controller
  
- Monday bata Native PHP garne
- Add built in Laravel Email Verification

- Make complete date same as assigned date, but when user doesn't say complete task even after assigned date, go on increasing complete date
- Make task->standard_timezone so that task can be notified on the standard task time

- Remove hardcoded text as far as possible like in email body (that is sent)
- Task Creator or admin can modify the task like in email "We are glad you've here...." and some footer type text
- For this, create Email Format table which stores task id and has 
  - Closing text
  - Signature (Cheers, Regards)
  - Signature text(Your Assistant Name, ...., .... (can be array of length 3)) 
  - Introductory text (introduction_text)

- Add filter of User (filter by Role, Timezone, Verified Email)
- Search User by name, email