testwork
========

<h1>Answers to "OUR QUESTIONS PART"</h1>

<p><b>How would you build a reference?</b></p>
<p>I would rely on doctrine ORM in this. After describing of the entity it's easy to generate sql migration using DoctrineMigrationsBundle</p>

<p>For the doctor entity I would use doctrine ManyToMany. In database layer it would be a separate table having columns id, patient_id, doctor_id</p>
<p>For invoice I assume that each invoice should have patient_id (The person who has to pay for services).
So in Patient doctrine entity we have OneToMany relation with Invoice entity to get collection of invoices and in Invoice entity
we have ManyToOne relation to get single Patient entity (owner of this Invoice). In database it will be table of invoices with patient_id column in it</p>


<h1>How to set up application</h1>

<p>Here we have pretty standard symfony based application. I use Vagrant for development, so please install it. Ansible (tool for provision) should also be installed</p>
<p>Once you've installed Vargrant and Ansible please clone project to which ever directory you like. After that call command "vagrant up" in your terminal</p>
<p>It will take a while for the first time, because vagrant will donwload box and run Ansible</p>
<p>It work fine with Ubuntu 14.04, Vagrant 1.8.6, ansible 2.3.0.0</p>
<p>Install composer dependencies. To achieve this please run "composer install"</p>
<p>Ssh to your box using command "vagrant ssh"</p>
<p>Being inside vagrant box run "php bin/console doctrine:migrations:migrate" to run migrations</p>
<p>Being inside vagrant box run "php bin/console doctrine:fixtures:load" to load fixture data</p>
<p>Application is ready for usage and available in browser by http://192.168.33.10 . Routes are defined via annotations inside PatientController</p>