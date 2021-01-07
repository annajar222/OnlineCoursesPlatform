<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="description" content="Do you want to learn and help other to learn? JustLearn is a place to put your courses and manage them, learn new things and help others to learn."/>
        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">

        <!-- Scripts -->
        <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.7.3/dist/alpine.js" defer></script>
        <style>
            .logo-img{
              max-width: 20%; 
              height:auto;
              padding-top:5px;
              padding-bottom: 5px;

            }

            @media (max-width: 600px) {
              .logo-img {
                max-width: 60%; 
                height:auto;
                padding-top:5px;
                padding-bottom: 5px;
                margin: auto;
              }
              .items{
                display: none;
              }
            }
        </style>
    </head>
  <body
    class="text-gray-700 bg-white"
    style="font-family: 'Source Sans Pro', sans-serif"
  >
    <!--Nav-->
    <nav class="items-center">
      <div
        class="container mx-auto py-2 flex justify-between items-center">
          <a href="/" class="inline-block transform hover:translate-x-1/6 transition-transform duration-1000 ease-out">
            <img src="{{url('/appLogo/logo.png')}}" class="logo-img" alt="logo">
          </a>
        <div class="items">
          <ul class="inline-flex">
            <li class="">
              <a class="px-8 font-bold hover:text-indigo-500 p-4 rounded-full" href="/login"
                >Login</a
              >
            </li>
            <li class="">
              <a class="px-8 font-bold  hover:text-indigo-500 p-4 rounded-full" href="/register"
                >Register</a
              >
            </li>
            <li class="">
              <a class="px-8 font-bold hover:text-indigo-500 p-4 rounded-full" href="#contact"
                >Contact</a
              >
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <!--Hero-->
    <div
      class="py-20"
      style="background: linear-gradient(90deg, #667eea 0%, #764ba2 100%)"
    >
      <div class="container mx-auto px-6">
        <h2 class="text-4xl font-bold mb-2 text-white">
          Here All Courses And Tutorials Available For Only Learning Purpose And Personal Use.
        </h2>
        <h3 class="text-2xl mb-8 text-gray-200">
          Try to learn and help others to learn.
        </h3>
        <a href="/login"
          class="bg-white font-bold rounded-full py-4 px-8 shadow-lg uppercase tracking-wider hover:shadow-xl"
        >
          sign in
        </a>
      </div>
    </div>
    <!-- Testimonials -->
    <section class="bg-white" id="about">
      <div class="container mx-auto px-6 py-20">
        <h2 class="text-4xl font-bold text-center text-gray-800 mb-8">
            About Justdemy
        </h2>
        <div class="text-center font-bold py-5">
              By connecting students all over the world to the best instructors, Justdemy is helping individuals reach their goals and pursue their dreams. 
        </div>
        <p class="text-center" >Stuck at home and eager to learn something new? Our list of free online learning courses offer classes from top universities and world-renowned institutions you can take now from anywhere you wish at anytime you choose!</p>
      </div>
    </section>
      <div id="contact" class="bg-white shadow-md rounded px-8 pt-6 pb-8 flex flex-col ">
        <h2 class="text-4xl font-bold text-center text-gray-800 mb-8">
          Contact Us
        </h2>
        <form action="{{route('send.mail')}}" method="post">
          @csrf
            <div class="-mx-3 md:flex mb-6">
              <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-first-name">
                  First Name
                </label>
                <input class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-3 px-4 mb-3" id="grid-first-name" name="firstname" type="text" placeholder="Jane.." required="required">
                <p class="text-red text-xs italic">Please fill out this field.</p>
              </div>
              <div class="md:w-1/2 px-3">
                <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-last-name">
                  Last Name
                </label>
                <input class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4" id="grid-last-name" name="lastname" type="text" placeholder="Doe.." required="required">
              </div>
              <div class="md:w-1/2 px-3">
                <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-email">
                  Email
                </label>
                <input class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4" id="grid-email" name="email" type="email" placeholder="Email.." required="required">
              </div>
            </div>
            <div class="-mx-3 md:flex mb-6">
              <div class="md:w-full px-3">
                <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-message">
                  Message
                </label>
                <textarea class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4 mb-3" id="grid-message" name="message" placeholder="Message.." required="required">
                </textarea>
                <p class="text-grey-dark text-xs italic">your message.</p>
              </div>
            </div>
            <div class="-mx-3 md:flex mb-6">
              <div class="md:w-full px-3">
                <button type="submit" class="bg-gray-50 font-bold rounded-full py-4 px-5 shadow-lg uppercase tracking-wider hover:shadow hover:bg-gray-50">Send</button>
              </div>
            </div>
        </form>
      </div>
    <!--Call to Action-->
    <section style="background-color: #667eea">
      <div class="container mx-auto px-6 text-center py-20">
        <h2 class="mb-6 text-4xl font-bold text-center text-white">
         Make your own Courses Now
        </h2>
        <h3 class="mb-6 text-2xl text-white">
         be part of the community
        </h3>
        <a href="/register"
          class="bg-white font-bold rounded-full mt-6 py-4 px-8 shadow-lg uppercase tracking-wider hover:shadow-xl"
        >
          Get Started
        </a>
      </div>
    </section>
    <!--Footer-->
    <footer class="bg-gray-100">
      <div class="container mx-auto px-6 pt-10 pb-6">
        <div class="flex flex-wrap">
          <div class="w-full md:w-1/4 text-center md:text-left ">
            <h5 class="uppercase mb-6 font-bold">Social</h5>
            <ul class="mb-4">
              <li class="mt-2">
                <a
                  href="#"
                  class="hover:underline text-gray-600 hover:text-orange-500"
                  >Facebook</a
                >
              </li>
              <li class="mt-2">
                <a
                  href="#"
                  class="hover:underline text-gray-600 hover:text-orange-500"
                  >Linkedin</a
                >
              </li>
              <li class="mt-2">
                <a
                  href="#"
                  class="hover:underline text-gray-600 hover:text-orange-500"
                  >Twitter</a
                >
              </li>
            </ul>
          </div>
          <div class="w-full md:w-1/4 text-center md:text-left ">
            <h5 class="uppercase mb-6 font-bold">Company</h5>
            <ul class="mb-4">
              <li class="mt-2">
                <a
                  href="#about"
                  class="hover:underline text-gray-600 hover:text-orange-500"
                  >About Us</a
                >
              </li>
              <li class="mt-2">
                <a
                  href="#contact"
                  class="hover:underline text-gray-600 hover:text-orange-500"
                  >Contact</a
                >
              </li>
            </ul>
          </div>
        </div>
        <div class="text-center">
          <small>&copy; Copyright 2021, Made with love by <span class="text-red-500">Annajar Mohamed.</span></small>
        </div>
      </div>
    </footer>
  </body>
</html>