**Events And Listeners**

Events and listeners are two awesome functionality to handle decouple module in a web application.The laravel Events follow the observer pattern, 
That allowing you to subscribe and listen for various events that occur in your application.The Laravel use Artisan to create event and listeners.
Event classes are typically stored in the app/Events directory, while their listeners are stored in app/Listeners, The initially these folders does 
not exist, but generate events and listeners folders using Artisan console commands.

**What Are Laravel Events And Listeners?**

An event is an action or occurrence that will happened into your application.The Application will raise events when something happens, 
The listeners will listen that event and react accordingly.The listeners is a program or method that will execute some logic or operation.

**Lets Create Events In Laravel 6.2**

We will create simple event which fired an event.The listener will listen that event and print log message.

We will generate **UserRegistered (Event)** and **SendWelcomeEmail (Listener)** file using CLI command.

    php artisan make:event UserRegistered
    php artisan make:listener SendWelcomeEmail --event="UserRegistered"

We will make one entry into **app/Providers/EventServiceProvide.php** file, this file is used to register all of your application’s event listeners.

    UserRegistered::class =>[
            SendWelcomeEmail::class,
        ],

Change Mail Driver from **config/mail.php**

    'driver' => env('MAIL_DRIVER', 'log'),
        
Now modified **handle()** method into **SendWelcomeEmail.php** file, that will have some program, that will execute when the even will occurred.

    public function handle(UserRegistered $event)
        {
            $data = array('name' => $event->newuser['name'], 'email' => $event->newuser['email']);
            try {
                if (!empty($data['email'])) {
                    Mail::send(['text' => 'mail'], $data, function ($message) use ($data) {
                        $message->to($data['email'])->subject
                        ('Laravel Basic Testing Mail');
                        $message->from('noreplay@mobiosolution.com');
                    });
                    echo "This is Email Sent to log. Check your log file.";
                }
            } catch (\Exception $e) {
                Log::info('Error' . $e->getMessage());
            }
        }

In our **UserRegistered** event we pass user object to it’s constructor. This object will then pass to the event listener.

    <?php

    namespace App\Events;

    use Illuminate\Foundation\Events\Dispatchable;
    use Illuminate\Queue\SerializesModels;

    class UserRegistered
    {
        use Dispatchable, SerializesModels;
    
        public $newuser;
        /**
         * Create a new event instance.
         *
         * @return void
         */
        public function __construct($newUser)
        {
            $this->newuser = $newUser;
        }
    }

**We have create one route for display Welcome Message.**

    Route::get('/display', 'WelcomeEventController@display')->name('display');

**How To dispatch Event In Laravel ?**

Let's Create one **WelcomeEventContoller** and that controller we will **dispatch Event**.
There another way to fire event by **creating new object of Event**.

    /*
     * Calling Event with method.
     * @return array
     */
    public function display()
    {
        $user = [
            'name' => 'Testuser',
            'email' => 'testuser@gmail.com',
        ];
        //call Event
        //UserRegistered::dispatch($user);
        event(new UserRegistered($user));
    }

    Output: Welcome to our Website Testuser.

Also add an Entry in Laravel log file when Event Fire.
