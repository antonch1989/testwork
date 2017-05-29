testwork
========

Answers to "OUR QUESTIONS PART"

<p><b>How would you build a reference?</b></p>
<p>I would rely on doctrine ORM in this. After describing of the entity it's easy to generate sql migration using DoctrineMigrationsBundle</p>

<p>For the doctor entity I would use doctrine ManyToMany. In database layer it would be a separate table having columns id, patient_id, doctor_id</p>
<p>For invoice I assume that each invoice should have patient_id (The person who has to pay for services).
So in Patient doctrine entity we have OneToMany relation with Invoice entity to get collection of invoices and in Invoice entity
we have ManyToOne relation to get single Patient entity (owner of this Invoice). In database it will be table of invoices with patient_id column in it</p>
