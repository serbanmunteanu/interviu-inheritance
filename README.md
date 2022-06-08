# Developer Updates:

- Application inspired by serial the "The good doctor" 
- The logic inside create a new Hospital that can process a list of Patient with symptoms
- In Hospital only patient that have insurance can be treated
- If no operation room is found and the patient is not lucky he will die
- If no doctor have knowledge about a disease the patient will be sent to another hospital
- The doctors can be assigned only for the diseases known by they

Some features:
- Can switch between cli / log by config (.log file in Output/Logs/history.log )
- Can add easily diseases and doctors by config ( simulating a database )
- Use composition and Static factory method + Adapters Pattern for logging

Final thoughts:
- The original assignment was too easy, so I implemented something challenging to show my skills and knowledge


<!-- GETTING STARTED -->
## About the project
This a small example on how inheritance affects our doctors professions by giving them
tasks that they should not be able to perform at all.

Performing surgeries as a family doctor is a big no-no since they do not teach you how to
perform surgeries when learning how to become a FAMILY doctor!

That is dangerous to be allowed in practice!
It could kill someone if done wrong!

<!-- About the task -->
## What to do
Cut our doctors powers to a realistic level of knowledge.

They should only practice what
they have been taught in medicine school according to their specialisation.

Refactor this example using composition as good as you can.

Try avoiding inheritance where it is possible.

Remember that Composition over inheritance is a principle we must generally strive for,
but we do not always follow it to the book.

## Hints
- Composition over inheritance
- Surgeries are actions/tasks
- Doctors are performing actions
- Surgeries can be of a certain medicine branch. Not all surgeries are taught in the same course.

## Other notes
- Keeping the current code structure is not a must.

### Composer prerequisites
  ```sh
  composer install 
  composer dump-autoload
  ```