<?php
ob_start();
session_start();
function show($lucid)
{
    // ------------- หัวข้อบทเรียน 52 สัปดาห์ ------------------------//    
    $weektopic[0] = '<div class="ss-row ss-small">
                        <div class="ss-left">
                            <h3>
                                WEEK 1 : Speaking - Greeting (การทักทาย)
                                <p>- วิดีโอสรุปบทเรียน week1</p>
                                <p>- FORMAL (แบบทางการ) </p>
                                <p>- INFORMAL (แบบไม่เป็นทางการ) </p>
                                <p>- One Day One Sentence Video by Lucas</p>
                                <p>- แบบฝึกหัด week1</p>
                            </h3>
                        </div>
                        <div class="ss-right">
                            <a class="ss-circle ss-circle-1">Fullscreen Image Blur Effect with HTML5</a>
                        </div>
                    </div>';

    $weektopic[1] = '<div class="ss-row ss-small">
                        <div class="ss-left">
                            <a class="ss-circle ss-circle-2">Interactive Typography Effects with HTML5</a>
                        </div>
                        <div class="ss-right">
                            <h3>
                                WEEK 2 : Speaking - Showing Gratitude / Saying thanks & Accepting thanks
                                <p>- วิดีโอสรุปบทเรียน week2</p>
                                <p>- Showing Gratitude / Saying thanks & Accepting thanks (การแสดงความขอบคุณ และตอบรับคําขอบคุณ)</p>
                                <p>- One Day One Sentence Video by Lucas</p>
                                <p>- แบบฝึกหัด week2</p>
                            </h3>
                        </div>
                    </div>';

    $weektopic[2] = '<div class="ss-row ss-small">
                        <div class="ss-left">
                            <h3>
                                WEEK 3 : Speaking
                                <p>- วิดีโอสรุปบทเรียน week3</p>
                                <p>- Apologizing / Saying Sorry (การกล่าวขอโทษและตอบรับคําขอโทษ)</p>
                                <p>- One Day One Sentence Video by Lucas</p>
                                <p>- แบบฝึกหัด week3</p>
                            </h3>
                        </div>
                        <div class="ss-right">
                            <a class="ss-circle ss-circle-3">Fullscreen Image Blur Effect with HTML5</a>
                        </div>
                    </div>';

    $weektopic[3] = '<div class="ss-row ss-small">
                        <div class="ss-left">
                            <a class="ss-circle ss-circle-4">Interactive Typography Effects with HTML5</a>
                        </div>
                        <div class="ss-right">
                            <h3>
                                WEEK 4 : Speaking
                                <p>- วิดีโอสรุปบทเรียน week4</p>
                                <p>- Leaving-Taking & Responding to Leaving-Taking (การกล่าวลาและตอบรับการกล่าวลา)</p>
                                <p>- One Day One Sentence Video by Lucas</p>
                                <p>- แบบฝึกหัด week4</p>
                            </h3>
                        </div>
                    </div>';

    $weektopic[4] = '<div class="ss-row ss-small">
                        <div class="ss-left">
                            <h3>
                                WEEK 5 : Speaking
                                <p>- วิดีโอสรุปบทเรียน week5</p>
                                <p>- See a Doctor & At the Pharmacy (ไปพบแพทย์ที่โรงพยาบาลและที่ร้านขายยา)</p>
                                <p>- One Day One Sentence Video by Lucas</p>
                                <p>- แบบฝึกหัด week5</p> 
                            </h3>
                        </div>
                        <div class="ss-right">
                            <a class="ss-circle ss-circle-5">Fullscreen Image Blur Effect with HTML5</a>
                        </div>
                    </div>';

    $weektopic[5] = '<div class="ss-row ss-small">
                        <div class="ss-left">
                            <a class="ss-circle ss-circle-6">Interactive Typography Effects with HTML5</a>
                        </div>
                        <div class="ss-right">
                            <h3>
                                WEEK 6 : Speaking
                                <p>- วิดีโอสรุปบทเรียน week6</p>
                                <p>- Asking and Offering for the Cost & Ordering Something (การสอบถามราคา การเสนอราคาของสินค้า และการสั่งซื้อสินค้า / สั่งอาหาร)</p>
                                <p>- One Day One Sentence Video by Lucas</p>
                                <p>- แบบฝึกหัด week6</p>
                            </h3>
                        </div>
                    </div>';

    $weektopic[6] = '<div class="ss-row ss-small">
                        <div class="ss-left">
                            <h3>
                                WEEK 7 : Grammar & Writing - Nouns (คํานาม)
                                <p>- วิดีโอสรุปบทเรียน week7</p>
                                <p>- การจําแนกคํานามออกเป็น 3 แบบ</p>
                                <p>- คํานามแบ่งตามรูป </p>
                                <p>- คํานามแบ่งตามการนับ </p>
                                <p>- คํานามแบ่งตามลักษณะการใช้ </p>
                                <p>- One Day One Sentence Video by Lucas</p>
                                <p>- แบบฝึกหัด week7</p>
                            </h3>
                        </div>
                        <div class="ss-right">
                            <a class="ss-circle ss-circle-7">Fullscreen Image Blur Effect with HTML5</a>
                        </div>
                    </div>';

    $weektopic[7] = '<div class="ss-row ss-small">
                        <div class="ss-left">
                            <a class="ss-circle ss-circle-8">Interactive Typography Effects with HTML5</a>
                        </div>
                        <div class="ss-right">
                            <h3>
                                WEEK 8 : Grammar & Writing - Pronouns (คําสรรพนาม)
                                <p>- วิดีโอสรุปบทเรียน week8</p>
                                <p>- หน้าที่หลักของคําสรรพนาม</p>
                                <p>- คําสรรพนาม 7 ประเภทหลัก </p>
                                <p>- One Day One Sentence Video by Lucas</p>
                                <p>- แบบฝึกหัด week8</p>
                            </h3>
                        </div>
                    </div>';

    $weektopic[8] = '<div class="ss-row ss-small">
                        <div class="ss-left">
                            <h3>
                                WEEK 9 : Vocabulary
                                <p>- วิดีโอสรุปบทเรียน week9</p>
                                <p>- Capitalization (หลักการใช้อักษรตัวพิมพ์ใหญ่)</p>
                                <p>- In the House (ศัพท์น่ารู้ภายในบ้าน)</p>
                                <p>- Nationality (ศัพท์เกี่ยวกับชนชาติ / เชื้อชาติ)</p>
                                <p>- One Day One Sentence Video by Lucas</p>
                                <p>- แบบฝึกหัด week9</p>
                            </h3>
                        </div>
                        <div class="ss-right">
                            <a class="ss-circle ss-circle-9">Fullscreen Image Blur Effect with HTML5</a>
                        </div>
                    </div>';

    $weektopic[9] = '<div class="ss-row ss-small">
                        <div class="ss-left">
                            <a class="ss-circle ss-circle-10">Interactive Typography Effects with HTML5</a>
                        </div>
                        <div class="ss-right">
                            <h3>
                                WEEK 10 : Speaking & Vocabulary
                                <p>- วิดีโอสรุปบทเรียน week10</p>
                                <p>- Talking About Weather (การพูดคุยเรื่องสภาพดินฟ้าอากาศแบบต่างๆ)</p>
                                <p>- Feelings (ศัพท์เกี่ยวกับความรู้สึก )</p>
                                <p>- One Day One Sentence Video by Lucas</p>
                                <p>- แบบฝึกหัด week10</p>
                            </h3>
                        </div>
                    </div>';

    $weektopic[10] = '<div class="ss-row ss-small">
                        <div class="ss-left">
                            <h3>
                                WEEK 11 : Grammar & Writing - Verbs (คํากริยา) ตอนที่ 1
                                <p>- วิดีโอสรุปบทเรียน week11</p>
                                <p>- Verb Forms (รูปแบบคํากริยา)</p>
                                <p>- Regular & Irregular Verbs (กลุ่มคํากริยาที่เปลี่ยนรูป)</p>
                                <p>- Finite & Non-finite Verbs (กริยาแท้และกริยาไม่แท้)</p>
                                <p>- One Day One Sentence Video by Lucas</p>
                                <p>- แบบฝึกหัด week11</p>
                            </h3>
                        </div>
                        <div class="ss-right">
                            <a class="ss-circle ss-circle-11">Fullscreen Image Blur Effect with HTML5</a>
                        </div>
                    </div>';

    $weektopic[11] = '<div class="ss-row ss-small">
                        <div class="ss-left">
                            <a class="ss-circle ss-circle-12">Interactive Typography Effects with HTML5</a>
                        </div>
                        <div class="ss-right">
                            <h3>
                                WEEK 12 : Grammar & Writing - Verbs (คํากริยา) ตอนที่ 2
                                <p>- วิดีโอสรุปบทเรียน week12</p>
                                <p>- Linking Verb</p>
                                <p>- Phrasal Verbs</p>
                                <p>- Gerunds (นามกริยา)</p>
                                <p>- One Day One Sentence Video by Lucas</p>
                                <p>- แบบฝึกหัด week12</p>
                            </h3>
                        </div>
                    </div>';

    $weektopic[12] = '<div class="ss-row ss-small">
                        <div class="ss-left">
                            <h3>
                                WEEK 13 : Test I / Grammar & Writing - Adjectives (คําคุณศัพท์)
                                <p>- วิดีโอสรุปบทเรียน week13</p>
                                <p>- Positions & Types of Adjectives (การวางตําแหน่งและชนิดของคําคุณศัพท์)</p>
                                <p>- Compound Adjectives (คําคุณศัพท์ที่ประกอบไปด้วยคําศัพท์ตั้งแต่ 2 คําขึ้นไป)</p>
                                <p>- Adjectives with to Infinitive and That Clauses (Adjectives ที่ เติม to-Infinitive Clause และ that Clause)</p>
                                <p>- One Day One Sentence Video by Lucas</p>
                                <p>- การประเมินผลครั้งที่ 1</p>
                                <p>- แบบฝึกหัด week13</p>
                            </h3>
                        </div>
                        <div class="ss-right">
                            <a class="ss-circle ss-circle-13">Fullscreen Image Blur Effect with HTML5</a>
                        </div>
                    </div>';

    $weektopic[13] = '<div class="ss-row ss-small">
                        <div class="ss-left">
                            <a class="ss-circle ss-circle-14">Interactive Typography Effects with HTML5</a>
                        </div>
                        <div class="ss-right">
                            <h3>
                                WEEK 14 : Vocabulary
                                <p>- วิดีโอสรุปบทเรียน week14</p>
                                <p>- Root Words, Prefixes, Suffixes (รากศัพท์ และคําที่เติมไว้ด้านหน้า และด้านหลังของรากศัพท์)</p>
                                <p>- Education (ศัพท์เกี่ยวกับการศึกษา)</p>
                                <p>- Occupations / Careers (ศัพท์เกี่ยวกับอาชีพ )</p>
                                <p>- One Day One Sentence Video by Lucas</p>
                                <p>- แบบฝึกหัด week14</p>
                            </h3>
                        </div>
                    </div>';

    $weektopic[14] = '<div class="ss-row ss-small">
                        <div class="ss-left">
                            <h3>
                                WEEK 15 : Grammar & Writing - Adverbs (คํากริยาวิศษณ์)
                                <p>- วิดีโอสรุปบทเรียน week15</p>
                                <p>- Functions, Types, Order (หน้าที่หลัก ชนิด และการเรียงลําดับคํากริยาวิเศษณ์ในประโยค)</p>
                                <p>- How to Create Adverbs? (วิธีการสร้างคํากริยาวิเศษณ์)</p>
                                <p>- One Day One Sentence Video by Lucas</p>
                                <p>- แบบฝึกหัด week15</p>
                            </h3>
                        </div>
                        <div class="ss-right">
                            <a class="ss-circle ss-circle-15">Fullscreen Image Blur Effect with HTML5</a>
                        </div>
                    </div>';

    $weektopic[15] = '<div class="ss-row ss-small">
                        <div class="ss-left">
                            <a class="ss-circle ss-circle-16">Interactive Typography Effects with HTML5</a>
                        </div>
                        <div class="ss-right">
                            <h3>
                                WEEK 16 : Grammar & Writing - Prepositions (คําบุพบท)
                                <p>- วิดีโอสรุปบทเรียน week16</p>
                                <p>- 6 ประเภทหลักของคําบุพบท</p>
                                <p>- Noun + Preposition (คํานามที่ตามด้วยคําบุพบท)</p>
                                <p>- Adjective + Preposition (คําคุณศัพท์ที่ตามด้วยคําบุพบท)</p>
                                <p>- One Day One Sentence Video by Lucas</p>
                                <p>- แบบฝึกหัด week16</p>
                            </h3>
                        </div>
                    </div>';

    $weektopic[16] = '<div class="ss-row ss-small">
                        <div class="ss-left">
                            <h3>
                                WEEK 17 : Grammar & Writing - Conjunctions / Linking Words (คําสันธาน)
                                <p>- วิดีโอสรุปบทเรียน week17</p>
                                <p>- Coordinating Conjunctions</p>
                                <p>- Correlative Conjunctions</p>
                                <p>- Subordinating Conjunctions</p>
                                <p>- One Day One Sentence Video by Lucas</p>
                                <p>- แบบฝึกหัด week17</p>
                            </h3>
                        </div>
                        <div class="ss-right">
                            <a class="ss-circle ss-circle-17">Fullscreen Image Blur Effect with HTML5</a>
                        </div>
                    </div>';

    $weektopic[17] = '<div class="ss-row ss-small">
                        <div class="ss-left">
                            <a class="ss-circle ss-circle-18">Interactive Typography Effects with HTML5</a>
                        </div>
                        <div class="ss-right">
                            <h3>
                                WEEK 18 : Vocabulary
                                <p>- วิดีโอสรุปบทเรียน week18</p>
                                <p>- Sports & Tourism</p>
                                <p>- Homograph (คําพ้องรูป) Homophone (คําพ้องเสียง)</p>
                                <p>- One Day One Sentence Video by Lucas</p>
                                <p>- แบบฝึกหัด week18</p>
                            </h3>
                        </div>
                    </div>';

    $weektopic[18] = '<div class="ss-row ss-small">
                        <div class="ss-left">
                            <h3>
                                WEEK 19 : Grammar & Writing - Interjections (คําอุทาน)
                                <p>- วิดีโอสรุปบทเรียน week19</p>
                                <p>- ชนิดของคําอุทาน</p>
                                <p>- Exclamation Sentences (3 รูปแบบหลักๆของคําอุทานที่เป็นประโยค)</p>
                                <p>- Talking about Food (การพูดคุยเกี่ยวกับอาหาร)</p>
                                <p>- One Day One Sentence Video by Lucas</p>
                                <p>- แบบฝึกหัด week19</p>
                            </h3>
                        </div>
                        <div class="ss-right">
                            <a class="ss-circle ss-circle-19">Fullscreen Image Blur Effect with HTML5</a>
                        </div>
                    </div>';

    $weektopic[19] = '<div class="ss-row ss-small">
                        <div class="ss-left">
                            <a class="ss-circle ss-circle-20">Interactive Typography Effects with HTML5</a>
                        </div>
                        <div class="ss-right">
                            <h3>
                                WEEK 20 : Vocabulary
                                <p>- วิดีโอสรุปบทเรียน week20</p>
                                <p>- Easily Confused Words (ศัพท์ที่มักใช้สับสน)</p>
                                <p>- Science / Technologies / Social Media (ศัพท์เกี่ยวกับวิทยาศาสตร์ เทคโนโลยี โซเชียลมีเดีย )</p>
                                <p>- One Day One Sentence Video by Lucas</p>
                                <p>- แบบฝึกหัด week20</p>
                            </h3>
                        </div>
                    </div>';

    $weektopic[20] = '<div class="ss-row ss-small">
                            <div class="ss-left">
                                <h3>
                                    WEEK 21 : Grammar & Writing
                                    <p>- วิดีโอสรุปบทเรียน week21</p>
                                    <p>- Articles</p>
                                    <p>- Determiner</p>
                                    <p>- One Day One Sentence Video by Lucas</p>
                                    <p>- แบบฝึกหัด week21</p>
                                </h3>
                            </div>
                            <div class="ss-right">
                                <a class="ss-circle ss-circle-21">Fullscreen Image Blur Effect with HTML5</a>
                            </div>
                        </div>';

    $weektopic[21] = '<div class="ss-row ss-small">
                            <div class="ss-left">
                                <a class="ss-circle ss-circle-22">Interactive Typography Effects with HTML5</a>
                            </div>
                            <div class="ss-right">
                                <h3>
                                    WEEK 22 : Grammar & Writing 
                                    <p>- วิดีโอสรุปบทเรียน week22</p>
                                    <p>- Sentence Structures</p>
                                    <p>- Diirect and Indirect Objects</p>
                                    <p>- One Day One Sentence Video by Lucas</p>
                                    <p>- แบบฝึกหัด week22</p>
                                </h3>
                            </div>
                        </div>';

    $weektopic[22] = '<div class="ss-row ss-small">
                            <div class="ss-left">
                                <h3>
                                    WEEK 23 : Vocabulary
                                    <p>- วิดีโอสรุปบทเรียน week23</p>
                                    <p>- Culture</p>
                                    <p>- Synonyms (ศัพท์ที่มีความหมายเหมือนกัน)</p>
                                    <p>- Antonyms (ศัพท์ท่ีมีความหมายต่างกัน)</p>
                                    <p>- One Day One Sentence Video by Lucas</p>
                                    <p>- แบบฝึกหัด week23</p>
                                </h3>
                            </div>
                            <div class="ss-right">
                                <a class="ss-circle ss-circle-23">Fullscreen Image Blur Effect with HTML5</a>
                            </div>
                        </div>';

    $weektopic[23] = '<div class="ss-row ss-small">
                            <div class="ss-left">
                                <a class="ss-circle ss-circle-24">Interactive Typography Effects with HTML5</a>
                            </div>
                            <div class="ss-right">
                                <h3>
                                    WEEK 24 : Grammar & Writing
                                    <p>- วิดีโอสรุปบทเรียน week24</p>
                                    <p>- Auxiliary Verbs (กริยาช่วย)</p>
                                    <p>- Verb to be, Verb to do, Verb to have</p>
                                    <p>- Modals Verbs</p>
                                    <p>- Transitive & Intransitive Verbs (กริยาที่ต้องการกรรมตรง และกริยาที่ไม่ต้องการกรรมตรง)</p>
                                    <p>- Verbs with Two Objects (กริยาในประโยคที่ตามด้วยกรรมตรง และกรรมรอง)</p>
                                    <p>- One Day One Sentence Video by Lucas</p>
                                    <p>- แบบฝึกหัด week24</p>
                                </h3>
                            </div>
                        </div>';

    $weektopic[24] = '<div class="ss-row ss-small">
                            <div class="ss-left">
                                <h3>
                                    WEEK 25 : Grammar & Writing - Conditional Clause / If-Clause
                                    <p>- วิดีโอสรุปบทเรียน week25</p>
                                    <p>- Present possible conditions</p>
                                    <p>- Present impossible conditions</p>
                                    <p>- Past impossible conditions</p>
                                    <p>- One Day One Sentence Video by Lucas</p>
                                    <p>- แบบฝึกหัด week25</p>
                                </h3>
                            </div>
                            <div class="ss-right">
                                <a class="ss-circle ss-circle-25">Fullscreen Image Blur Effect with HTML5</a>
                            </div>
                        </div>';

    $weektopic[25] = '<div class="ss-row ss-small">
                            <div class="ss-left">
                                <a class="ss-circle ss-circle-26">Interactive Typography Effects with HTML5</a>
                            </div>
                            <div class="ss-right">
                                <h3>
                                    WEEK 26 : Test II / Grammar & Writing
                                    <p>- วิดีโอสรุปบทเรียน week26</p>
                                    <p>- There is / There are</p>
                                    <p>- This / That / These / Those</p>
                                    <p>- One Day One Sentence Video by Lucas</p>
                                    <p>- การประเมินผลครั้งที่ 2</p>
                                    <p>- แบบฝึกหัด week26</p>
                                </h3>
                            </div>
                        </div>';

    $weektopic[26] = '<div class="ss-row ss-small">
                            <div class="ss-left">
                                <h3>
                                    WEEK 27 : Grammar & Writing
                                    <p>- วิดีโอสรุปบทเรียน week27</p>
                                    <p>- Present Simple Tense</p>
                                    <p>- Present Continuous Tense</p>
                                    <p>- One Day One Sentence Video by Lucas</p>
                                    <p>- แบบฝึกหัด week27</p>
                                </h3>
                            </div>
                            <div class="ss-right">
                                <a class="ss-circle ss-circle-27">Fullscreen Image Blur Effect with HTML5</a>
                            </div>
                        </div>';

    $weektopic[27] = '<div class="ss-row ss-small">
                            <div class="ss-left">
                                <a class="ss-circle ss-circle-28">Interactive Typography Effects with HTML5</a>
                            </div>
                            <div class="ss-right">
                                <h3>
                                    WEEK 28 : Grammar & Writing
                                    <p>- วิดีโอสรุปบทเรียน week28</p>
                                    <p>- Present Perfect Tense</p>
                                    <p>- Present Perfect Continuous Tense</p>
                                    <p>- One Day One Sentence Video by Lucas</p>
                                    <p>- แบบฝึกหัด week28</p>
                                </h3>
                            </div>
                        </div>';

    $weektopic[28] = '<div class="ss-row ss-small">
                            <div class="ss-left">
                                <h3>
                                    WEEK 29 : Grammar & Writing
                                    <p>- วิดีโอสรุปบทเรียน week29</p>
                                    <p>- Past Simple Tense</p>
                                    <p>- Past Continuous Tense</p>
                                    <p>- One Day One Sentence Video by Lucas</p>
                                    <p>- แบบฝึกหัด week29</p>
                                </h3>
                            </div>
                            <div class="ss-right">
                                <a class="ss-circle ss-circle-29">Fullscreen Image Blur Effect with HTML5</a>
                            </div>
                        </div>';

    $weektopic[29] = '<div class="ss-row ss-small">
                            <div class="ss-left">
                                <a class="ss-circle ss-circle-30">Interactive Typography Effects with HTML5</a>
                            </div>
                            <div class="ss-right">
                                <h3>
                                    WEEK 30 : Grammar & Writing
                                    <p>- วิดีโอสรุปบทเรียน week30</p>
                                    <p>- Past Perfect Tense</p>
                                    <p>- Past Perfect Continuous Tense</p>
                                    <p>- One Day One Sentence Video by Lucas</p>
                                    <p>- แบบฝึกหัด week30</p>
                                </h3>
                            </div>
                        </div>';

    $weektopic[30] = '<div class="ss-row ss-small">
                            <div class="ss-left">
                                <h3>
                                    WEEK 31 : Grammar & Writing
                                    <p>- วิดีโอสรุปบทเรียน week31</p>
                                    <p>- Future Simple Tense</p>
                                    <p>- Future Continuous Tense</p>
                                    <p>- One Day One Sentence Video by Lucas</p>
                                    <p>- แบบฝึกหัด week31</p>
                                </h3>
                            </div>
                            <div class="ss-right">
                                <a class="ss-circle ss-circle-31">Fullscreen Image Blur Effect with HTML5</a>
                            </div>
                        </div>';

    $weektopic[31] = '<div class="ss-row ss-small">
                            <div class="ss-left">
                                <a class="ss-circle ss-circle-32">Interactive Typography Effects with HTML5</a>
                            </div>
                            <div class="ss-right">
                                <h3>
                                    WEEK 32 : Grammar & Writing
                                    <p>- วิดีโอสรุปบทเรียน week32</p>
                                    <p>- Future Perfect Tense</p>
                                    <p>- Future Perfect Continuous Tense</p>
                                    <p>- One Day One Sentence Video by Lucas</p>
                                    <p>- แบบฝึกหัด week32</p>    
                                </h3>
                            </div>
                        </div>';

    $weektopic[32] = '<div class="ss-row ss-small">
                            <div class="ss-left">
                                <h3>
                                    WEEK 33 : Grammar & Writing
                                    <p>- วิดีโอสรุปบทเรียน week33</p>
                                    <p>- Active & Passive Voices (วิธีการพูดในภาษาอังกฤษ 2 แบบ)</p>
                                    <p>- Making a Request</p>
                                    <p>- One Day One Sentence Video by Lucas</p>
                                    <p>- แบบฝึกหัด week33</p>
                                </h3>
                            </div>
                            <div class="ss-right">
                                <a class="ss-circle ss-circle-33">Fullscreen Image Blur Effect with HTML5</a>
                            </div>
                        </div>';

    $weektopic[33] = '<div class="ss-row ss-small">
                            <div class="ss-left">
                                <a class="ss-circle ss-circle-34">Interactive Typography Effects with HTML5</a>
                            </div>
                            <div class="ss-right">
                                <h3>
                                    WEEK 34 : Grammar & Writing
                                    <p>- วิดีโอสรุปบทเรียน week34</p>
                                    <p>- Comparatives & Superlatives</p>
                                    <p>- Comparison</p>
                                    <p>- One Day One Sentence Video by Lucas</p>
                                    <p>- แบบฝึกหัด week34</p>
                                </h3>
                            </div>
                        </div>';

    $weektopic[34] = '<div class="ss-row ss-small">
                            <div class="ss-left">
                                <h3>
                                    WEEK 35 : Grammar & Writing
                                    <p>- วิดีโอสรุปบทเรียน week35</p>
                                    <p>- Relative Clauses (ประโยคย่อยที่ขยายความ)</p>
                                    <p>- Two or More Tenses (การใช้ Tense 2 Tense ขึ้นไปภายในประโยค)</p>
                                    <p>- One Day One Sentence Video by Lucas</p>
                                    <p>- แบบฝึกหัด week35</p>
                                </h3>
                            </div>
                            <div class="ss-right">
                                <a class="ss-circle ss-circle-35">Fullscreen Image Blur Effect with HTML5</a>
                            </div>
                        </div>';

    $weektopic[35] = '<div class="ss-row ss-small">
                            <div class="ss-left">
                                <a class="ss-circle ss-circle-36">Interactive Typography Effects with HTML5</a>
                            </div>
                            <div class="ss-right">
                                <h3>
                                    WEEK 36 : Reading
                                    <p>- วิดีโอสรุปบทเรียน week36</p>
                                    <p>- Reading for Main Ideas (การอ่านเพื่อหาใจความหลักของเรื่อง)</p>
                                    <p>- Topic & Title (ชื่อเรื่อง/บทความ)</p>
                                    <p>- One Day One Sentence Video by Lucas</p>
                                    <p>- แบบฝึกหัด week36</p>
                                </h3>
                            </div>
                        </div>';

    $weektopic[36] = '<div class="ss-row ss-small">
                            <div class="ss-left">
                                <h3>
                                    WEEK 37 : Reading
                                    <p>- วิดีโอสรุปบทเรียน week37</p>
                                    <p>- Reading for Specific Details (การอ่านเพื่อหาข้อมูลเฉพาะเจาะจง)</p>
                                    <p>- Skimming & Scanning Reading (การอ่านแบบข้ามและแบบคร่าว)</p>
                                    <p>- One Day One Sentence Video by Lucas</p>
                                    <p>- แบบฝึกหัด week37</p>
                                </h3>
                            </div>
                            <div class="ss-right">
                                <a class="ss-circle ss-circle-37">Fullscreen Image Blur Effect with HTML5</a>
                            </div>
                        </div>';

    $weektopic[37] = '<div class="ss-row ss-small">
                            <div class="ss-left">
                                <a class="ss-circle ss-circle-38">Interactive Typography Effects with HTML5</a>
                            </div>
                            <div class="ss-right">
                                <h3>
                                    WEEK 38 : Reading
                                    <p>- วิดีโอสรุปบทเรียน week38</p>
                                    <p>- Reference: Noun & Pronoun References (การใช้คํานามและสรรพนามอ้างถึงคําอื่นที่มาก่อน)</p>
                                    <p>- One Day One Sentence Video by Lucas</p>
                                    <p>- แบบฝึกหัด week38</p>
                                </h3>
                            </div>
                        </div>';

    $weektopic[38] = '<div class="ss-row ss-small">
                            <div class="ss-left">
                                <h3>
                                    WEEK 39 : Test III & Reading
                                    <p>- วิดีโอสรุปบทเรียน week39</p>
                                    <p>- Determining Meaning of Words from Context (การค้นหาความหมายของคําจากบริบท)</p>
                                    <p>- One Day One Sentence Video by Lucas</p>
                                    <p>- การประเมินผลครั้งที่ 3</p>
                                    <p>- แบบฝึกหัด week39</p>
                                </h3>
                            </div>
                            <div class="ss-right">
                                <a class="ss-circle ss-circle-39">Fullscreen Image Blur Effect with HTML5</a>
                            </div>
                        </div>';

    $weektopic[39] = '<div class="ss-row ss-small">
                            <div class="ss-left">
                                <a class="ss-circle ss-circle-40">Interactive Typography Effects with HTML5</a>
                            </div>
                            <div class="ss-right">
                                <h3>
                                    WEEK 40 : Reading
                                    <p>- วิดีโอสรุปบทเรียน week40</p>
                                    <p>- Irrelevance (การวิเคราะห์หาสิ่งที่ไม่เกี่ยวข้องในเนื้อหาบทความ)</p>
                                    <p>- One Day One Sentence Video by Lucas</p>
                                    <p>- แบบฝึกหัด week40</p>
                                </h3>
                            </div>
                        </div>';

    $weektopic[40] = '<div class="ss-row ss-small">
                            <div class="ss-left">
                                <h3>
                                    WEEK 41 : Reading
                                    <p>- วิดีโอสรุปบทเรียน week41</p>
                                    <p>- Drawing Inferences (การอนุมานจากประโยคต่างๆ ในบทความ)</p>
                                    <p>- One Day One Sentence Video by Lucas</p>
                                    <p>- แบบฝึกหัด week41</p>
                                </h3>
                            </div>
                            <div class="ss-right">
                                <a class="ss-circle ss-circle-41">Fullscreen Image Blur Effect with HTML5</a>
                            </div>
                        </div>';

    $weektopic[41] = '<div class="ss-row ss-small">
                            <div class="ss-left">
                                <a class="ss-circle ss-circle-42">Interactive Typography Effects with HTML5</a>
                            </div>
                            <div class="ss-right">
                                <h3>
                                    WEEK 42 : Reading
                                    <p>- วิดีโอสรุปบทเรียน week42</p>
                                    <p>- Author’s Purpose (จุดประสงค์ของผู้เขียน)</p>
                                    <p>- Intended Audience (กลุ่มผู้อ่านเป้าหมาย)</p>
                                    <p>- Facts & Opinions (การจําแนกข้อเท็จจริง และความคิดเห็นหรือทัศนคติ)</p>
                                    <p>- One Day One Sentence Video by Lucas</p>
                                    <p>- แบบฝึกหัด week42</p>
                                </h3>
                            </div>
                        </div>';

    $weektopic[42] = '<div class="ss-row ss-small">
                            <div class="ss-left">
                                <h3>
                                    WEEK 43 : Reading
                                    <p>- วิดีโอสรุปบทเรียน week43</p>
                                    <p>- Drawing Conclusion (การสรุปความ)</p>
                                    <p>- One Day One Sentence Video by Lucas</p>
                                    <p>- แบบฝึกหัด week43</p>
                                </h3>
                            </div>
                            <div class="ss-right">
                                <a class="ss-circle ss-circle-43">Fullscreen Image Blur Effect with HTML5</a>
                            </div>
                        </div>';

    $weektopic[43] = '<div class="ss-row ss-small">
                            <div class="ss-left">
                                <a class="ss-circle ss-circle-44">Interactive Typography Effects with HTML5</a>
                            </div>
                            <div class="ss-right">
                                <h3>
                                    WEEK 44 : Speaking & Reading
                                    <p>- วิดีโอสรุปบทเรียน week44</p>
                                    <p>- Speaking : Making an Appointment</p>
                                    <p>- Reading : Reading Memos</p>
                                    <p>- One Day One Sentence Video by Lucas</p>
                                    <p>- แบบฝึกหัด week44</p>
                                </h3>
                            </div>
                        </div>';

    $weektopic[44] = '<div class="ss-row ss-small">
                            <div class="ss-left">
                                <h3>
                                    WEEK 45 : Speaking
                                    <p>- วิดีโอสรุปบทเรียน week45</p>
                                    <p>- Phone Conversation</p>
                                    <p>- One Day One Sentence Video by Lucas</p>
                                    <p>- แบบฝึกหัด week45</p>
                                </h3>
                            </div>
                            <div class="ss-right">
                                <a class="ss-circle ss-circle-45">Fullscreen Image Blur Effect with HTML5</a>
                            </div>
                        </div>';

    $weektopic[45] = '<div class="ss-row ss-small">
                            <div class="ss-left">
                                <a class="ss-circle ss-circle-46">Interactive Typography Effects with HTML5</a>
                            </div>
                            <div class="ss-right">
                                <h3>
                                    WEEK 46 : Speaking
                                    <p>- วิดีโอสรุปบทเรียน week46</p>
                                    <p>- Careers & Job Interview</p>
                                    <p>- Occupations/ Careers</p>
                                    <p>- One Day One Sentence Video by Lucas</p>
                                    <p>- แบบฝึกหัด week46</p>
                                </h3>
                            </div>
                        </div>';

    $weektopic[46] = '<div class="ss-row ss-small">
                            <div class="ss-left">
                                <h3>
                                    WEEK 47 : Vocabulary
                                    <p>- วิดีโอสรุปบทเรียน week47</p>
                                    <p>- American & British English</p>
                                    <p>- One Day One Sentence Video by Lucas</p>
                                    <p>- แบบฝึกหัด week47</p>
                                </h3>
                            </div>
                            <div class="ss-right">
                                <a class="ss-circle ss-circle-47">Fullscreen Image Blur Effect with HTML5</a>
                            </div>
                        </div>';

    $weektopic[47] = '<div class="ss-row ss-small">
                            <div class="ss-left">
                                <a class="ss-circle ss-circle-48">Interactive Typography Effects with HTML5</a>
                            </div>
                            <div class="ss-right">
                                <h3>
                                    WEEK 48 : Writing
                                    <p>- วิดีโอสรุปบทเรียน week48</p>
                                    <p>- Basic Writing Essay</p>
                                    <p>- Introduction / Body / Conclusion</p>
                                    <p>- One Day One Sentence Video by Lucas</p>
                                    <p>- แบบฝึกหัด week48</p>
                                </h3>
                            </div>
                        </div>';


    $weektopic[48] = '<div class="ss-row ss-small">
                            <div class="ss-left">
                                <h3>
                                    WEEK 49 : Writing
                                    <p>- วิดีโอสรุปบทเรียน week49</p>
                                    <p>- Writing a Resume / CV</p>
                                    <p>- Reading Application Forms and Resumes</p>
                                    <p>- One Day One Sentence Video by Lucas</p>
                                    <p>- แบบฝึกหัด week49</p>
                                </h3>
                            </div>
                            <div class="ss-right">
                                <a class="ss-circle ss-circle-49">Fullscreen Image Blur Effect with HTML5</a>
                            </div>
                        </div>';

    $weektopic[49] = '<div class="ss-row ss-small">
                            <div class="ss-left">
                                <a class="ss-circle ss-circle-50">Interactive Typography Effects with HTML5</a>
                            </div>
                            <div class="ss-right">
                                <h3>
                                    WEEK 50 : Writing
                                    <p>- วิดีโอสรุปบทเรียน week50</p>
                                    <p>- Story of writing</p>
                                    <p>- One Day One Sentence Video by Lucas</p>
                                    <p>- แบบฝึกหัด week50</p>
                                </h3>
                            </div>
                        </div>';

    $weektopic[50] = '<div class="ss-row ss-small">
                            <div class="ss-left">
                                <h3>
                                    WEEK 51 : Writing
                                    <p>- วิดีโอสรุปบทเรียน week51</p>
                                    <p>- Coherence & Cohesion</p>
                                    <p>- Writing an Email</p>
                                    <p>- One Day One Sentence Video by Lucas</p>
                                    <p>- แบบฝึกหัด week51</p>
                                </h3>
                            </div>
                            <div class="ss-right">
                                <a class="ss-circle ss-circle-51">Fullscreen Image Blur Effect with HTML5</a>
                            </div>
                        </div>';

    $weektopic[51] = '<div class="ss-row ss-small">
                            <div class="ss-left">
                                <a class="ss-circle ss-circle-52">Interactive Typography Effects with HTML5</a>
                            </div>
                        <div class="ss-right">
                            <h3>
                                WEEK 52 : Test
                                <p>- Final test </p>
                            </h3>
                        </div>
                    </div>'; //------------------------------------------------------------------//    

    // $exercise_1y = array(1, 2, 3, 4, 5, 6);
    $exercise_1y[0] = '<div id="ss-container" class="ss-container">
                            <div class="ss-row">
                                <div class="ss-left">
                                    <h2 id="week1">Week</h2>
                                </div>
                                <div class="ss-right">
                                    <h2>1</h2>
                                </div>
                            </div>
				
                            <div class="ss-row ss-large">
                                <div class="ss-left">
                                    <a class="ss-circle ss-circle-1">เริ่มทดสอบใน สัปดาห์ที่ 1 ได้ ณ เวลานี้</a>
                                </div>
                                <div class="ss-right">
                                    <h3>
                                        <span class="tbntoggle" id="tbn_1">WEEK 1 : Speaking - Greeting (การทักทาย)
                                            <div class="menu" id="menu1">
                                                <p><u><b>บทเรียน</b></u></p>
                                                <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=4903 ">วิดีโอสรุปบทเรียน Week1</a></p>
                                                <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=2535 ">เนื้อหา Greeting</a></p>
                                                <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=4768 ">One Day One Sentence Video by Lucas</a></p>
                                                <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=4902 ">การบ้าน Week1</a></p>
                                            </div>
                                        </span>        
                                    </h3>
                                </div>
                            </div>';


    $exercise_1y[1] = '<div class="ss-row">
                            <div class="ss-left">
                                <h2 id="week2">Week</h2>
                            </div>
                            <div class="ss-right">
                                <h2>2</h2>
                            </div>
                        </div>
                        <div class="ss-row ss-large">
                            <div class="ss-left">
                                <h3>
                                    <span class="tbntoggle" id="tbn_2">WEEK 2 : Speaking - Showing Gratitude / Saying thanks & Accepting thanks
                                        <div class="menu" id="menu2">
                                            <p> <u>บทเรียน</u></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=1">วิดีโอสรุปบทเรียน Week2</a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=2441">เนื้อหา Showing Gratitude / Saying thanks & Accepting thanks</a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=4774">One Day One Sentence Video by Lucas</a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=2">What is EOL</a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=4793">เฉลยการบ้าน week1 และการบ้าน Week2</a></p>
                                        </div>
                                    </span>
                                </h3>
                            </div>
                            <div class="ss-right">
                                <a href="#" class="ss-circle  ss-circle-2">Wave Display Effect with jQuery</a>
                            </div>
                        </div>';

    $exercise_1y[2] = '<div class="ss-row">
                            <div class="ss-left">
                                <h2 id="week3">Week</h2>
                            </div>
                            <div class="ss-right">
                                <h2>3</h2>
                            </div>
                       </div>
                        <div class="ss-row ss-large">
                            <div class="ss-left">
                                <a href="" class="ss-circle ss-circle-3">Responsive Image Gallery with Thumbnail Carousel</a>
                            </div>
                            <div class="ss-right">
                                <h3>
                                    <span class="tbntoggle" id="tbn_3">WEEK 3 : Speaking - Apologizing / Say Sorry 
                                        <div class="menu" id="menu3">
                                            <p> <u>บทเรียน</u></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=4798">วิดีโอสรุปบทเรียน Week3</a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=2444">เนื้อหา Apologizing / Saying Sorry</a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=4772">One Day One Sentence Video by Lucas</a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=3">เฉลยการบ้าน week2 และการบ้าน Week3</a></p>
                                        </div>
                                    </span>
                                </h3>
                            </div>
                        </div>';

    $exercise_1y[3] = '<div class="ss-row">
                            <div class="ss-left">
                                <h2 id="week4">Week</h2>
                            </div>
                            <div class="ss-right">
                                <h2>4</h2>
                            </div>
                       </div>
                        <div class="ss-row ss-large">
                            <div class="ss-left">
                                <h3>
                                    <span class="tbntoggle" id="tbn_4">WEEK 4 : Speaking - Leaving-Talking & Responding to Leaving-Talking
                                        <div class="menu" id="menu4">
                                            <p><u>บทเรียน</u></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=5">วิดีโอสรุปบทเรียน Week4</a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=2561">เนื้อหา Leaving-Talking & Responding to Leaving-Talking</a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=4776">One Day One Sentence Video by Lucas</a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=4">เฉลยการบ้าน week3 และการบ้าน Week4</a></p>
                                        </div>
                                    </span>
                                </h3>
                            </div>
                            <div class="ss-right">
                                <a href="" class="ss-circle ss-circle-4">Automatic Image Montage with jQuery</a>
                            </div>
                        </div>';


    $exercise_1y[4] = '<div class="ss-row">
                            <div class="ss-left">
                                <h2 id="week5">Week</h2>
                            </div>
                            <div class="ss-right">
                                <h2>5</h2>
                            </div>
                       </div>
                        <div class="ss-row ss-large">
                            <div class="ss-left">
                                <a href="" class="ss-circle ss-circle-5">Responsive Image Gallery with Thumbnail Carousel</a>
                            </div>
                            <div class="ss-right">
                                <h3>
                                    <span class="tbntoggle" id="tbn_5">WEEK 5 : Speaking - See a Doctor & At the Pharmacy
                                        <div class="menu" id="menu5">
                                            <p><u>บทเรียน</u></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=6">วิดีโอสรุปบทเรียน Week5</a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=3128">เนื้อหา See a Doctor & At the Pharmacy</a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=4782">One Day One Sentence Video by Lucas</a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=9">เฉลยการบ้าน week4 และการบ้าน Week5</a></p>
                                        </div>
                                    </span>
                                </h3>
                            </div>
                        </div>';


    $exercise_1y[5] = ' <div class="ss-row">
                            <div class="ss-left">
                                <h2 id="week6">Week</h2>
                            </div>
                            <div class="ss-right">
                                <h2>6</h2>
                            </div>
                        </div>
                        <div class="ss-row ss-large">
                            <div class="ss-left">
                                <h3>
                                    <span class="tbntoggle" id="tbn_6">WEEK 6 : Speaking - Asking and Offering for the Cost & Ordering Something
                                        <div class="menu" id="menu6">
                                            <p> <u>บทเรียน</u></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=7">วิดีโอสรุปบทเรียน Week6</a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=2466">เนื้อหา Speaking - Asking and Offering for the Cost & Ordering Something</a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=4784">One Day One Sentence Video by Lucas</a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=10">เฉลยการบ้าน week5 และการบ้าน Week6</a></p>
                                        </div>
                                    </span>
                                </h3>
                            </div>
                            <div class="ss-right">
                                <a href="" class="ss-circle ss-circle-6">Automatic Image Montage with jQuery</a>
                            </div>
                        </div>';


    $exercise_1y[6] = ' <div class="ss-row">
                            <div class="ss-left">
                                <h2 id="week7">Week</h2>
                            </div>
                            <div class="ss-right">
                                <h2>7</h2>
                            </div>
                        </div>
                        <div class="ss-row ss-large">
                            <div class="ss-left">
                                <a href="" class="ss-circle ss-circle-7">Responsive Image Gallery with Thumbnail Carousel</a>
                            </div>
                            <div class="ss-right">
                                <h3>
                                    <span class="tbntoggle" id="tbn_7">WEEK 7 : Grammar & Writing  - NOUNS (คำนาม)
                                        <div class="menu" id="menu7">
                                            <p> <u>บทเรียน</u></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=8">วิดีโอสรุปบทเรียน Week7</a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=336">เนื้อหา NOUNS</a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=4785">One Day One Sentence Video by Lucas</a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=13">เฉลยการบ้าน week6 และการบ้าน Week7</a></p>
                                        </div>
                                    </span>
                                </h3>
                            </div>
                        </div>';


    $exercise_1y[7] = ' <div class="ss-row">
                            <div class="ss-left">
                                <h2 id="week8">Week</h2>
                            </div>
                            <div class="ss-right">
                                <h2>8</h2>
                            </div>
                        </div>
                        <div class="ss-row ss-large">
                            <div class="ss-left">
                                <h3>
                                    <span class="tbntoggle" id="tbn_8">WEEK 8 : Grammar & Writing - PRONOUNS (คําสรรพนาม)
                                        <div class="menu" id="menu8">
                                            <p> <u>บทเรียน</u></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=12" >วิดีโอสรุปบทเรียน Week8</a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=340" >เนื้อหา PRONOUNS</a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=4787" >One Day One Sentence Video by Lucas</a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=18" >เฉลยการบ้าน week7 และการบ้าน Week8</a></p>
                                        </div>
                                    </span>
                                </h3>
                            </div>
                            <div class="ss-right">
                                <a href="" class="ss-circle ss-circle-8">Automatic Image Montage with jQuery</a>
                            </div>
                        </div>';

    $exercise_1y[8] = ' <div class="ss-row">
                            <div class="ss-left">
                                <h2 id="week9">Week</h2>
                            </div>
                            <div class="ss-right">
                                <h2>9</h2>
                            </div>
                        </div>
                        <div class="ss-row ss-large">
                            <div class="ss-left">
                                <a href="" class="ss-circle ss-circle-9">Responsive Image Gallery with Thumbnail Carousel</a>
                            </div>
                            <div class="ss-right">
                                <h3>
                                    <span class="tbntoggle" id="tbn_9">WEEK : 9 Vocabulary
                                        <div class="menu" id="menu9">
                                            <p> <u>บทเรียน</u></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=17" >วิดีโอสรุปบทเรียน Week9</a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=2911" >Capitalization (หลักการใช้อักษรตัวพิมพ์ใหญ่)</a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=4538" >In the House (ศัพท์น่ารู้ภายในบ้าน)</a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=3372" >Nationality (ศัพท์เกี่ยวกับชนชาติ/ เชื้อชาติ)</a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=4801" >One Day One Sentence Video by Lucas</a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=19" >เฉลยการบ้าน week8 และการบ้าน Week9</a></p>
                                        </div>
                                    </span>
                                </h3>
                            </div>
                        </div>';


    $exercise_1y[9] = ' <div class="ss-row">
                            <div class="ss-left">
                                <h2 id="week10">Week</h2>
                            </div>
                            <div class="ss-right">
                                <h2>10</h2>
                            </div>
                        </div>
                        <div class="ss-row ss-large">
                            <div class="ss-left">
                                <h3>
                                    <span class="tbntoggle" id="tbn_10">WEEK 10 : Speaking - Talking About Weather
                                        <div class="menu" id="menu10">
                                            <p> <u>บทเรียน</u></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=21" >วิดีโอสรุปบทเรียน Week10</a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=3121" >Talking About Weather (การพูดคุยเรื่องสภาพดินฟ้าอากาศแบบต่างๆ)</a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=4536" >Vocabulary (ศัพท์เกี่ยวกับความรู้สึก)</a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=4803" >One Day One Sentence</a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=20" >เฉลยการบ้าน week9 และการบ้าน Week10</a></p>
                                        </div>
                                    </span>
                                </h3>
                            </div>
                            <div class="ss-right">
                                <a href="" class="ss-circle ss-circle-10">Automatic Image Montage with jQuery</a>
                            </div>
                        </div>';

    $exercise_1y[10] = ' <div class="ss-row">
                            <div class="ss-left">
                                <h2 id="week11">Week</h2>
                            </div>
                            <div class="ss-right">
                                <h2>11</h2>
                            </div>
                        </div>
                        <div class="ss-row ss-large">
                            <div class="ss-left">
                                <a href="" class="ss-circle ss-circle-11">Responsive Image Gallery with Thumbnail Carousel</a>
                            </div>
                            <div class="ss-right">
                                <h3>
                                    <span class="tbntoggle" id="tbn_11">WEEK 11 : Grammar & Writing - Verbs (คํากริยา) ตอนที่ 1
                                        <div class="menu" id="menu11">
                                            <p> <u>บทเรียน</u></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=4810" >วิดีโอสรุปบทเรียน Week11</a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=580" >เนื้อหา Verb Forms, Regular & Irregular Verbs </a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=4806" >One Day One Sentence Video by Lucas</a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=4814" >เฉลยการบ้าน week10 และการบ้าน Week11</a></p>
                                        </div>
                                    </span>
                                </h3>
                            </div>
                        </div>';

    $exercise_1y[11] = ' <div class="ss-row">
                            <div class="ss-left">
                                <h2 id="week12">Week</h2>
                            </div>
                            <div class="ss-right">
                                <h2>12</h2>
                            </div>
                        </div>
                        <div class="ss-row ss-large">
                            <div class="ss-left">
                                <h3>
                                    <span class="tbntoggle" id="tbn_12">WEEK 12 : Grammar & Writing - Verbs (คํากริยา) ตอนที่ 2
                                        <div class="menu" id="menu12">
                                            <p> <u>บทเรียน</u></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=4857" >วิดีโอสรุปบทเรียน Week12</a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=583" >เนื้อหา Linking Verbs</a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=1554">เนื้อหา Gerunds (นามกริยา)</a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=4624" >One Day One Sentence Video by Lucas</a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=4817" >เฉลยการบ้าน week11 และการบ้าน Week12</a></p>
                                        </div>
                                    </span>
                                </h3>
                            </div>
                            <div class="ss-right">
                                <a href="" class="ss-circle ss-circle-12">Automatic Image Montage with jQuery</a>
                            </div>
                        </div>';


    $exercise_1y[12] = '<div class="ss-row">
                            <div class="ss-left">
                                <h2 id="week13">Week</h2>
                            </div>
                            <div class="ss-right">
                                <h2>13</h2>
                            </div>
                        </div>
                        <div class="ss-row ss-large">
                            <div class="ss-left">
                                <a href="" class="ss-circle ss-circle-13">Responsive Image Gallery with Thumbnail Carousel</a>
                            </div>
                            <div class="ss-right">
                                <h3>
                                    <span class="tbntoggle" id="tbn_13">WEEK 13 : Test I / Grammar & Writing - Adjectives (คําคุณศัพท์)
                                        <div class="menu" id="menu13">
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=3280" > การประเมินผลครั้งที่ 1</a></p>
                                            <p> <u>บทเรียน</u></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=4812" >วิดีโอสรุปบทเรียน Week13</a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=339" >เนื้อหา Positions & Types of Adjectives</a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=4520">เนื้อหา Adjectives with to Infinitive and That Clauses</a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=4625" >One Day One Sentence Video by Lucas</a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=4818" >เฉลยการบ้าน week12 และการบ้าน Week13</a></p>
                                        </div>
                                    </span>
                                </h3>
                            </div>
                        </div>';

    $exercise_1y[13] = '<div class="ss-row">
                            <div class="ss-left">
                                <h2 id="week14">Week</h2>
                            </div>
                            <div class="ss-right">
                                <h2>14</h2>
                            </div>
                        </div>
                        <div class="ss-row ss-large">
                            <div class="ss-left">
                                <h3>
                                    <span class="tbntoggle" id="tbn_14">WEEK : 14 Vocabulary
                                        <div class="menu" id="menu14">
                                            <p> <u>บทเรียน</u></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=4816" >วิดีโอสรุปบทเรียน Week14</a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=2901" >เนื้อหา Root Words, Prefixes, Suffixes</a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=4795" >เนื้อหา Vocabulary Education </a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=4769" >เนื้อหา Vocabulary Occupations/ Careers </a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=4627" >One Day One Sentence Video by Lucas</a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=4819" >เฉลยการบ้าน week13 และการบ้าน Week14</a></p>
                                        </div>
                                    </span>
                                </h3>
                            </div>
                            <div class="ss-right">
                                <a href="" class="ss-circle ss-circle-14">Automatic Image Montage with jQuery</a>
                            </div>
                        </div>';


    $exercise_1y[14] = '<div class="ss-row">
                            <div class="ss-left">
                                <h2 id="week15">Week</h2>
                            </div>
                            <div class="ss-right">
                                <h2>15</h2>
                            </div>
                        </div>
                        <div class="ss-row ss-large">
                            <div class="ss-left">
                                <a href="" class="ss-circle ss-circle-15">Responsive Image Gallery with Thumbnail Carousel</a>
                            </div>
                            <div class="ss-right">
                                <h3>
                                    <span class="tbntoggle" id="tbn_15">WEEK : 15 Grammar & Writing - Adverbs (คํากริยาวิเศษณ์)
                                        <div class="menu" id="menu15">
                                            <p> <u>บทเรียน</u></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=4815" >วิดีโอสรุปบทเรียน Week15</a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=341" >เนื้อหา Functions, Types, Order</a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=4809" >One Day One Sentence Video by Lucas</a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=4820" >เฉลยการบ้าน week14 และการบ้าน Week15</a></p>
                                        </div>
							        </span>
                                </h3>
                            </div>
                        </div>';

    $exercise_1y[15] = '<div class="ss-row">
                            <div class="ss-left">
                                <h2 id="week16">Week</h2>
                            </div>
                            <div class="ss-right">
                                <h2>16</h2>
                            </div>
                        </div>
                        <div class="ss-row ss-large">
                            <div class="ss-left">
                                <h3>
                                    <span class="tbntoggle" id="tbn_16">WEEK : 16 Grammar & Writing - Prepositions (คําบุพบท)
                                        <div class="menu" id="menu16">
                                            <p> <u>บทเรียน</u></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=4823" >วิดีโอสรุปบทเรียน Week16</a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=342" >เนื้อหา Prepositions</a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=4821" >One Day One Sentence Video by Lucas</a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=4825" >เฉลยการบ้าน week15 และการบ้าน Week16</a></p>
                                        </div>
                                    </span>
                                </h3>
                            </div>
                            <div class="ss-right">
                                <a href="" class="ss-circle ss-circle-16">Automatic Image Montage with jQuery</a>
                            </div>
                        </div>';

    $exercise_1y[16] = '<div class="ss-row">
                            <div class="ss-left">
                                <h2 id="week17">Week</h2>
                            </div>
                            <div class="ss-right">
                                <h2>17</h2>
                            </div>
                        </div>
                        <div class="ss-row ss-large">
                            <div class="ss-left">
                                <a href="" class="ss-circle ss-circle-17">Responsive Image Gallery with Thumbnail Carousel</a>
                            </div>
                            <div class="ss-right">
                                <h3>
                                    <span class="tbntoggle" id="tbn_17">WEEK : 17 Grammar & Writing - Conjunctions / Linking Words (คําสันธาน)
                                        <div class="menu" id="menu17">
                                            <p> <u>บทเรียน</u></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=4827" >วิดีโอสรุปบทเรียน Week17</a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=1614" >เนื้อหา Conjunctions</a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=3235" >เนื้อหา Coordinating Conjunctions</a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=3236" >เนื้อหา Correlative Conjunctions</a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=3237" >เนื้อหา Subordinating Conjunctions</a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=4660" >One Day One Sentence Video by Lucas</a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=4830" >เฉลยการบ้าน week16 และการบ้าน Week17</a></p>
                                        </div>
                                    </span>
                                </h3>
                            </div>
                        </div>';

    $exercise_1y[17] = '<div class="ss-row">
                            <div class="ss-left">
                                <h2 id="week18">Week</h2>
                            </div>
                            <div class="ss-right">
                                <h2>18</h2>
                            </div>
                        </div>
                        <div class="ss-row ss-large">
                            <div class="ss-left">
                                <h3>
                                    <span class="tbntoggle" id="tbn_18">WEEK : 18 Vocabulary - Sports & Tourism
                                        <div class="menu" id="menu18">
                                            <p> <u>บทเรียน</u></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=4828" >วิดีโอสรุปบทเรียน Week18 : Sports & Tourism </a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=4791" >เนื้อหา Vocabulary : Sports & Tourism</a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=4858" >วิดีโอสรุปบทเรียน Week18 : homograph Homophone </a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=2894" >เนื้อหา Homograph</a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=2895" >เนื้อหา Homophone</a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=4655" >One Day One Sentence Video by Lucas</a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=4831" >เฉลยการบ้าน week17 และการบ้าน Week18</a></p>
                                        </div>
                                    </span>
                                </h3>
                            </div>
                            <div class="ss-right">
                                <a href="" class="ss-circle ss-circle-18"></a>
                            </div>
                        </div>';


    $exercise_1y[18] = '<div class="ss-row">
                            <div class="ss-left">
                                <h2 id="week19">Week</h2>
                            </div>
                            <div class="ss-right">
                                <h2>19</h2>
                            </div>
                        </div>
                        <div class="ss-row ss-large">
                            <div class="ss-left">
                                <a href="" class="ss-circle ss-circle-19"></a>
                            </div>
                            <div class="ss-right">
                                <h3>
                                    <span class="tbntoggle" id="tbn_19">WEEK : 19 Grammar & Writing - Interjections (คําอุทาน)
                                        <div class="menu" id="menu19">
                                            <p> <u>บทเรียน</u></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=4829" >วิดีโอสรุปบทเรียน Week19 </a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=575" >เนื้อหา Interjections</a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=4651" >One Day One Sentence Video by Lucas</a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=4833" >เฉลยการบ้าน week18 และการบ้าน Week19</a></p>
                                        </div>
                                    </span>
                                </h3>
                            </div>
                        </div>';

    $exercise_1y[19] = '<div class="ss-row">
                            <div class="ss-left">
                                <h2 id="week20">Week</h2>
                            </div>
                            <div class="ss-right">
                                <h2>20</h2>
                            </div>
                        </div>
                        <div class="ss-row ss-large">
                            <div class="ss-left">
                                <h3>
                                    <span class="tbntoggle" id="tbn_20">WEEK : 20 Vocabulary - Easily Confused Words
                                        <div class="menu" id="menu20">
                                            <p> <u>บทเรียน</u></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=4832" >วิดีโอสรุปบทเรียน Week20 </a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=2893" >เนื้อหา Easily Confused Words</a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=4649" >One Day One Sentence Video by Lucas</a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=25" >เฉลยการบ้าน week19 และการบ้าน Week20</a></p>
                                        </div>
                                    </span>
                                </h3>
                            </div>
                            <div class="ss-right">
                                <a href="" class="ss-circle ss-circle-20"></a>
                            </div>
                        </div>';


    $exercise_1y[20] = '<div class="ss-row">
                            <div class="ss-left">
                                <h2 id="week21">Week</h2>
                            </div>
                            <div class="ss-right">
                                <h2>21</h2>
                            </div>
                        </div>
                        <div class="ss-row ss-large">
                            <div class="ss-left">
                                <a href="" class="ss-circle ss-circle-21"></a>
                            </div>
                            <div class="ss-right">
                                <h3>
                                    <span class="tbntoggle" id="tbn_21">WEEK : 21 Grammar & Writing - Articles & Determiner
                                        <div class="menu" id="menu21">
                                            <p> <u>บทเรียน</u></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=4834" >วิดีโอสรุปบทเรียน Week21 </a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=334" >เนื้อหา Articles</a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=335" >เนื้อหา Determiner</a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=4646" >One Day One Sentence Video by Lucas</a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=4836" >เฉลยการบ้าน week20 และการบ้าน Week21</a></p>
                                        </div>
                                    </span>
                                </h3>
                            </div>
                        </div>';

    $exercise_1y[21] = '<div class="ss-row">
                            <div class="ss-left">
                                <h2 id="week22">Week</h2>
                            </div>
                            <div class="ss-right">
                                <h2>22</h2>
                            </div>
                        </div>
                        <div class="ss-row ss-large">
                            <div class="ss-left">
                                <h3>
                                    <span class="tbntoggle" id="tbn_22">WEEK : 22 Grammar & Writing - Sentence Structures
                                        <div class="menu" id="menu22">
                                            <p> <u>บทเรียน</u></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=23" >วิดีโอสรุปบทเรียน Week22 </a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=1586" >เนื้อหา Sentence Structures</a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.phptopic_id=4639" >One Day One Sentence Video by Lucas</a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=4838" >เฉลยการบ้าน week21 และการบ้าน Week22</a></p>
                                        </div>
                                    </span>
                                </h3>
                            </div>
                            <div class="ss-right">
                                <a href="" class="ss-circle ss-circle-22"></a>
                            </div>
                        </div>';

    $exercise_1y[22] = '<div class="ss-row">
                            <div class="ss-left">
                                <h2 id="week23">Week</h2>
                            </div>
                            <div class="ss-right">
                                <h2>23</h2>
                            </div>
                        </div>
                        <div class="ss-row ss-large">
                            <div class="ss-left">
                                <a href="" class="ss-circle ss-circle-23"></a>
                            </div>
                            <div class="ss-right">
                                <h3>
                                    <span class="tbntoggle" id="tbn_23">WEEK : 23 Vocabulary - Culture
                                        <div class="menu" id="menu23">
                                            <p> <u>บทเรียน</u></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=4841" >วิดีโอสรุปบทเรียน Week23 </a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=4792" >เนื้อหา Vocabulary - Culture</a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=2902" >เนื้อหา Synonyms</a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=2892" >เนื้อหา Antonyms</a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=4637" >One Day One Sentence Video by Lucas</a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=4839" >เฉลยการบ้าน week22 และการบ้าน Week23</a></p>
                                        </div>
                                    </span>
                                </h3>
                            </div>
                        </div>';

    $exercise_1y[23] = '<div class="ss-row">
                            <div class="ss-left">
                                <h2 id="week24">Week</h2>
                            </div>
                            <div class="ss-right">
                                <h2>24</h2>
                            </div>
                        </div>
                        <div class="ss-row ss-large">
                            <div class="ss-left">
                                <h3>
                                    <span class="tbntoggle" id="tbn_24">WEEK : 24 Grammar & Writing - Auxiliary Verbs
                                        <div class="menu" id="menu24">
                                        <p> <u>บทเรียน</u></p>
                                        <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=24" >วิดีโอสรุปบทเรียน Week24 </a></p>
                                        <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=582" >เนื้อหา Auxiliary Verbs</a></p>
                                        <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=3135" >เนื้อหา Verb to be, Verb to do, Verb to have</a></p>
                                        <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=4634" >One Day One Sentence Video by Lucas</a></p>
                                        <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=4842" >เฉลยการบ้าน week23 และการบ้าน Week24</a></p>
                                        </div>
                                    </span>
                                </h3>
                            </div>
                            <div class="ss-right">
                                <a href="" class="ss-circle ss-circle-24"></a>
                            </div>
                        </div>';

    $exercise_1y[24] = '<div class="ss-row">
                            <div class="ss-left">
                                <h2 id="week25">Week</h2>
                            </div>
                            <div class="ss-right">
                                <h2>25</h2>
                            </div>
                        </div>
                        <div class="ss-row ss-large">
                            <div class="ss-left">
                                <a href="" class="ss-circle ss-circle-25"></a>
                            </div>
                            <div class="ss-right">
                                <h3>
                                    <span class="tbntoggle" id="tbn_25">WEEK : 25 Grammar & Writing - Conditional Clause / If-Clause 
                                        <div class="menu" id="menu25">
                                            <p> <u>บทเรียน</u></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=#" >วิดีโอสรุปบทเรียน Week25 </a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=3167" >เนื้อหา Conditional sentence I</a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=1599" >เนื้อหา Conditional sentences II</a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=4632" >One Day One Sentence Video by Lucas</a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=4843" >เฉลยการบ้าน week24 และการบ้าน Week25</a></p>
                                        </div>
                                    </span>
                                </h3>
                            </div>
                        </div>';

    $exercise_1y[25] = '<div class="ss-row">
                            <div class="ss-left">
                                <h2 id="week26">Week</h2>
                            </div>
                            <div class="ss-right">
                                <h2>26</h2>
                            </div>
                        </div>
                        <div class="ss-row ss-large">
                            <div class="ss-left">
                                <h3>
                                    <span class="tbntoggle" id="tbn_26">WEEK : 26 Test II /  Grammar & Writing - There is / There are
                                        <div class="menu" id="menu26">
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=3351" > การประเมินผลครั้งที่ 2</a></p>
                                            <p> <u>บทเรียน</u></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=4849" >วิดีโอสรุปบทเรียน Week26 </a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=1610" >เนื้อหา There is / There are</a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=4631" >One Day One Sentence Video by Lucas</a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=4844" >เฉลยการบ้าน week25 และการบ้าน Week26</a></p>
                                        </div>
                                    </span>
                                </h3>
                            </div>
                            <div class="ss-right">
                                <a href="" class="ss-circle ss-circle-26"></a>
                            </div>
                        </div>';


    $exercise_1y[26] = '<div class="ss-row">
                            <div class="ss-left">
                                <h2 id="week27">Week</h2>
                            </div>
                            <div class="ss-right">
                                <h2>27</h2>
                            </div>
                        </div>
                        <div class="ss-row ss-large">
                            <div class="ss-left">
                                <a href="" class="ss-circle ss-circle-27"></a>
                            </div>
                            <div class="ss-right">
                                <h3>
                                    <span class="tbntoggle" id="tbn_27">WEEK : 27 Grammar & Writing - Present Simple Tense / Present Continuous Tense
                                        <div class="menu" id="menu27">
                                            <p> <u>บทเรียน</u></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=4850" >วิดีโอสรุปบทเรียน Week27 </a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=344" >เนื้อหา Present Simple Tense</a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=345" >เนื้อหา Present Continuous Tense</a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=4630" >One Day One Sentence Video by Lucas</a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=4845" >เฉลยการบ้าน week26 และการบ้าน Week27</a></p>
                                        </div>
                                    </span>
                                </h3>
                            </div>
                        </div>';

    $exercise_1y[27] = '<div class="ss-row">
                            <div class="ss-left">
                                <h2 id="week28">Week</h2>
                            </div>
                            <div class="ss-right">
                                <h2>28</h2>
                            </div>
                        </div>
                        <div class="ss-row ss-large">
                            <div class="ss-left">
                                <h3>
                                    <span class="tbntoggle" id="tbn_28">WEEK : 28 Grammar & Writing - Present Perfect Tense / Present Perfect Continuous Tense
                                        <div class="menu" id="menu28">
                                            <p> <u>บทเรียน</u></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=4851" >วิดีโอสรุปบทเรียน Week28 </a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=346" >เนื้อหา Present Perfect Tense</a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=1590" >เนื้อหา Present Perfect Continuous Tense</a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=4629" >One Day One Sentence Video by Lucas</a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=4846" >เฉลยการบ้าน week27 และการบ้าน Week28</a></p>
                                        </div>
                                    </span>
                                </h3>
                            </div>
                            <div class="ss-right">
                                <a href="" class="ss-circle ss-circle-28"></a>
                            </div>
                        </div>';

    $exercise_1y[28] = '<div class="ss-row">
                            <div class="ss-left">
                                <h2 id="week29">Week</h2>
                            </div>
                            <div class="ss-right">
                                <h2>29</h2>
                            </div>
                        </div>
                        <div class="ss-row ss-large">
                            <div class="ss-left">
                                <a href="" class="ss-circle ss-circle-29"></a>
                            </div>
                            <div class="ss-right">
                                <h3>
                                    <span class="tbntoggle" id="tbn_29">WEEK : 29 Grammar & Writing - Past Simple Tense / Past Continuous Tense
                                        <div class="menu" id="menu29">
                                            <p> <u>บทเรียน</u></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=4852" >วิดีโอสรุปบทเรียน Week29 </a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=347" >เนื้อหา Past Simple Tense</a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=348" >เนื้อหา Past Continuous Tense</a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=4628" >One Day One Sentence Video by Lucas</a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=4847" >เฉลยการบ้าน week28 และการบ้าน Week29</a></p>
                                        </div>
                                    </span>
                                </h3>
                            </div>
                        </div>';

    $exercise_1y[29] = '<div class="ss-row">
                            <div class="ss-left">
                                <h2 id="week30">Week</h2>
                            </div>
                            <div class="ss-right">
                                <h2>30</h2>
                            </div>
                        </div>
                        <div class="ss-row ss-large">
                            <div class="ss-left">
                                <h3>
                                    <span class="tbntoggle" id="tbn_30">WEEK : 30 Grammar & Writing - Past Perfect Tense / Past Perfect Continuous Tense
                                        <div class="menu" id="menu30">
                                            <p> <u>บทเรียน</u></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=4853" >วิดีโอสรุปบทเรียน Week30 </a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=1591" >เนื้อหา Past Perfect Tense</a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=1592" >เนื้อหา Past Perfect Continuous Tense</a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=4612" >One Day One Sentence Video by Lucas</a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=4848" >เฉลยการบ้าน week29 และการบ้าน Week30</a></p>
                                        </div>
                                    </span>
                                </h3>
                            </div>
                            <div class="ss-right">
                                <a href="" class="ss-circle ss-circle-30"></a>
                            </div>
                        </div>';

    $exercise_1y[30] = '<div class="ss-row">
                            <div class="ss-left">
                                <h2 id="week31">Week</h2>
                            </div>
                            <div class="ss-right">
                                <h2>31</h2>
                            </div>
                        </div>
                        <div class="ss-row ss-large">
                            <div class="ss-left">
                                <a href="" class="ss-circle ss-circle-31"></a>
                            </div>
                            <div class="ss-right">
                                <h3>
                                    <span class="tbntoggle" id="tbn_31">WEEK : 31 Grammar & Writing - Future Simple Tense / Future Continuous Tense
                                        <div class="menu" id="menu31">
                                            <p> <u>บทเรียน</u></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=4853" >วิดีโอสรุปบทเรียน Week31 </a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=349" >เนื้อหา Future Simple Tense</a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=1593" >เนื้อหา Future Continuous Tense</a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=4622" >One Day One Sentence Video by Lucas</a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=4859" >เฉลยการบ้าน week30 และการบ้าน Week31</a></p>
                                        </div>
                                    </span>
                                </h3>
                            </div>
                        </div>';

    $exercise_1y[31] = '<div class="ss-row">
                            <div class="ss-left">
                                <h2 id="week32">Week</h2>
                            </div>
                            <div class="ss-right">
                                <h2>32</h2>
                            </div>
                        </div>
                        <div class="ss-row ss-large">
                            <div class="ss-left">
                                <h3>
                                    <span class="tbntoggle" id="tbn_32">WEEK : 32 Grammar & Writing - Future Perfect Tense / Future Perfect Continuous Tense
                                        <div class="menu" id="menu32">
                                            <p> <u>บทเรียน</u></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=4855" >วิดีโอสรุปบทเรียน Week32 </a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=1594" >เนื้อหา Future Perfect Tense</a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=1595" >เนื้อหา Future Perfect Continuous Tense</a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=4620" >One Day One Sentence Video by Lucas</a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=4860" >เฉลยการบ้าน week31 และการบ้าน Week32</a></p>
                                        </div>
                                    </span>
                                </h3>
                            </div>
                            <div class="ss-right">
                                <a href="" class="ss-circle ss-circle-32"></a>
                            </div>
                        </div>';

    $exercise_1y[32] = '<div class="ss-row">
                            <div class="ss-left">
                                <h2 id="week33">Week</h2>
                            </div>
                            <div class="ss-right">
                                <h2>33</h2>
                            </div>
                        </div>
                        <div class="ss-row ss-large">
                            <div class="ss-left">
                                <a href="" class="ss-circle ss-circle-33"></a>
                            </div>
                            <div class="ss-right">
                                <h3>
                                    <span class="tbntoggle" id="tbn_33">WEEK : 33 Grammar & Writing - Active & Passive Voices / Making a Request
                                        <div class="menu" id="menu33">
                                            <p> <u>บทเรียน</u></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=4856" >วิดีโอสรุปบทเรียน Week33 </a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=1597" >เนื้อหา Active & Passive Voices</a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=452" >เนื้อหา Making a Request</a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=4618" >One Day One Sentence Video by Lucas</a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=4861" >เฉลยการบ้าน week32 และการบ้าน Week33</a></p>
                                        </div>
                                    </span>
                                </h3>
                            </div>
                        </div>';

    $exercise_1y[33] = '<div class="ss-row">
                            <div class="ss-left">
                                <h2 id="week34">Week</h2>
                            </div>
                            <div class="ss-right">
                                <h2>34</h2>
                            </div>
                        </div>
                        <div class="ss-row ss-large">
                            <div class="ss-left">
                                <h3>
                                    <span class="tbntoggle" id="tbn_34">WEEK : 34 Grammar & Writing - Comparatives & Superlatives / Comparison
                                        <div class="menu" id="menu34">
                                            <p> <u>บทเรียน</u></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=4863" >วิดีโอสรุปบทเรียน Week34 </a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=1105" >เนื้อหา Comparatives & Superlatives</a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=1099" >เนื้อหา Comparison : AS ... AS </a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=1101" >เนื้อหา Comparison : SO ... AS </a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=4617" >One Day One Sentence Video by Lucas</a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=4865" >เฉลยการบ้าน week33 และการบ้าน Week34</a></p>
                                        </div>
                                    </span>
                                </h3>
                            </div>
                            <div class="ss-right">
                                <a href="" class="ss-circle ss-circle-34"></a>
                            </div>
                        </div>';

    $exercise_1y[34] = '<div class="ss-row">
                            <div class="ss-left">
                                <h2 id="week35">Week</h2>
                            </div>
                            <div class="ss-right">
                                <h2>35</h2>
                            </div>
                        </div>
                        <div class="ss-row ss-large">
                            <div class="ss-left">
                                <a href="" class="ss-circle ss-circle-35"></a>
                            </div>
                            <div class="ss-right">
                                <h3>
                                    <span class="tbntoggle" id="tbn_35">WEEK : 35 Grammar & Writing - Relative Clauses / Two or More Tenses
                                        <div class="menu" id="menu35">
                                            <p> <u>บทเรียน</u></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=4864" >วิดีโอสรุปบทเรียน Week35 </a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=1598" >เนื้อหา Relative Clauses</a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=4503" >เนื้อหา Two or More Tenses </a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=4608" >One Day One Sentence Video by Lucas</a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=4867" >เฉลยการบ้าน week34 และการบ้าน Week35</a></p>
                                        </div>
							        </span>
                                </h3>
                            </div>
                        </div>';

    $exercise_1y[35] = '<div class="ss-row">
                            <div class="ss-left">
                                <h2 id="week36">Week</h2>
                            </div>
                            <div class="ss-right">
                                <h2>36</h2>
                            </div>
                        </div>
                        <div class="ss-row ss-large">
                            <div class="ss-left">
                                <h3>
                                    <span class="tbntoggle" id="tbn_36">WEEK : 36 Reading - Reading for Main Ideas / Topic & Title
                                        <div class="menu" id="menu36">
                                            <p> <u>บทเรียน</u></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=4869" >วิดีโอสรุปบทเรียน Week36 </a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=352" >เนื้อหา Reading for Main Ideas</a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=2475" >เนื้อหา Topic and Title </a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=467" >เนื้อหา Skimming </a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=4607" >One Day One Sentence Video by Lucas</a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=4870" >เฉลยการบ้าน week35 และการบ้าน Week36</a></p>
                                        </div>
                                    </span>
                                </h3>
                            </div>
                            <div class="ss-right">
                                <a href="" class="ss-circle ss-circle-36"></a>
                            </div>
                        </div>';


    $exercise_1y[36] = '<div class="ss-row">
                            <div class="ss-left">
                                <h2 id="week37">Week</h2>
                            </div>
                            <div class="ss-right">
                                <h2>37</h2>
                            </div>
                        </div>
                        <div class="ss-row ss-large">
                            <div class="ss-left">
                                <a href="" class="ss-circle ss-circle-37"></a>
                            </div>
                            <div class="ss-right">
                                <h3>
                                    <span class="tbntoggle" id="tbn_37">WEEK : 37 Reading - Reading for Specific Details / Skimming & Scanning Reading
                                        <div class="menu" id="menu37">
                                            <p> <u>บทเรียน</u></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=4881" >วิดีโอสรุปบทเรียน Week37 </a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=3452" >เนื้อหา Reading for Specific Details</a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=397" >เนื้อหา Skimming & Scanning Reading </a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=4575" >One Day One Sentence Video by Lucas</a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=4871" >เฉลยการบ้าน week36 และการบ้าน Week37</a></p>
                                        </div>
                                    </span>
                                </h3>
                            </div>
                        </div>';

    $exercise_1y[37] = '<div class="ss-row">
                            <div class="ss-left">
                                <h2 id="week38">Week</h2>
                            </div>
                            <div class="ss-right">
                                <h2>38</h2>
                            </div>
                        </div>
                        <div class="ss-row ss-large">
                            <div class="ss-left">
                                <h3>
                                    <span class="tbntoggle" id="tbn_38">WEEK : 38 Reading - Reference: Noun & Pronoun References 
                                        <div class="menu" id="menu38">
                                            <p> <u>บทเรียน</u></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=4884" >วิดีโอสรุปบทเรียน Week38 </a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=2472" >เนื้อหา Reference: Noun & Pronoun References</a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.phptopic_id=4578" >One Day One Sentence Video by Lucas</a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=4872" >เฉลยการบ้าน week37 และการบ้าน Week38</a></p>
                                        </div>
                                    </span>
                                </h3>
                            </div>
                            <div class="ss-right">
                                <a href="" class="ss-circle ss-circle-38"></a>
                            </div>
                        </div>';

    $exercise_1y[38] = '<div class="ss-row">
                            <div class="ss-left">
                                <h2 id="week39">Week</h2>
                            </div>
                            <div class="ss-right">
                                <h2>39</h2>
                            </div>
                        </div>
                        <div class="ss-row ss-large">
                            <div class="ss-left">
                                <a href="" class="ss-circle ss-circle-39"></a>
                            </div>
                            <div class="ss-right">
                                <h3>
                                    <span class="tbntoggle" id="tbn_39">WEEK : 39 Test III / Reading - Determining Meaning of Words from Context
                                        <div class="menu" id="menu39">
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=3352" > การประเมินผลครั้งที่ 3</a></p>
                                            <p> <u>บทเรียน</u></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=4886" >วิดีโอสรุปบทเรียน Week39 </a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.phptopic_id=3183" >เนื้อหา Determining Meaning of Words from Context</a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=4589" >One Day One Sentence Video by Lucas</a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=4873" >เฉลยการบ้าน week38 และการบ้าน Week39</a></p>
                                        </div>
                                    </span>
                                </h3>
                            </div>
                        </div>';

    $exercise_1y[39] = '<div class="ss-row">
                            <div class="ss-left">
                                <h2 id="week40">Week</h2>
                            </div>
                            <div class="ss-right">
                                <h2>40</h2>
                            </div>
                        </div>
                        <div class="ss-row ss-large">
                            <div class="ss-left">
                                <h3>
                                    <span class="tbntoggle" id="tbn_40">WEEK : 40 Reading - Irrelevance
                                    <div class="menu" id="menu40">
                                        <p> <u>บทเรียน</u></p>
                                        <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=4892" >วิดีโอสรุปบทเรียน Week40 </a></p>
                                        <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=1311" >เนื้อหา Irrelevance</a></p>
                                        <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=4590" >One Day One Sentence Video by Lucas</a></p>
                                        <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=4874" >เฉลยการบ้าน week39 และการบ้าน Week40</a></p>
                                    </div>
                                </span>
                                </h3>
                            </div>
                            <div class="ss-right">
                                <a href="" class="ss-circle ss-circle-40"></a>
                            </div>
                        </div>';

    $exercise_1y[40] = '<div class="ss-row">
                            <div class="ss-left">
                                <h2 id="week41">Week</h2>
                            </div>
                            <div class="ss-right">
                                <h2>41</h2>
                            </div>
                        </div>
                        <div class="ss-row ss-large">
                            <div class="ss-left">
                                <a href="" class="ss-circle ss-circle-41"></a>
                            </div>
                            <div class="ss-right">
                                <h3>
                                    <span class="tbntoggle" id="tbn_41">WEEK : 41 Reading - Drawing Inferences
                                        <div class="menu" id="menu41">
                                            <p> <u>บทเรียน</u></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=4893" >วิดีโอสรุปบทเรียน Week41 </a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=3989" >เนื้อหา Drawing Inferences</a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=4590" >One Day One Sentence Video by Lucas</a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=4875" >เฉลยการบ้าน week40 และการบ้าน Week41</a></p>
                                        </div>
                                    </span>
                                </h3>
                            </div>
                        </div>';

    $exercise_1y[41] = '<div class="ss-row">
                            <div class="ss-left">
                                <h2 id="week42">Week</h2>
                            </div>
                            <div class="ss-right">
                                <h2>42</h2>
                            </div>
                        </div>
                        <div class="ss-row ss-large">
                            <div class="ss-left">
                                <h3>
                                    <span class="tbntoggle" id="tbn_42">WEEK : 42 Reading - Author’s Purpose / Intended Audience / Facts & Opinions
                                        <div class="menu" id="menu42">
                                            <p> <u>บทเรียน</u></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=4898" >วิดีโอสรุปบทเรียน Week42 </a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=3198" >เนื้อหา Author’s Purpose</a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=3197" >เนื้อหา Intended Audience</a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=2948" >เนื้อหา Facts & Opinions</a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=4901" >One Day One Sentence Video by Lucas</a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=4876" >เฉลยการบ้าน week41 และการบ้าน Week42</a></p>
                                        </div>
                                    </span>
                                </h3>
                            </div>
                            <div class="ss-right">
                                <a href="" class="ss-circle ss-circle-42"></a>
                            </div>
                        </div>';

    $exercise_1y[42] = '<div class="ss-row">
                            <div class="ss-left">
                                <h2 id="week43">Week</h2>
                            </div>
                            <div class="ss-right">
                                <h2>43</h2>
                            </div>
                        </div>
                        <div class="ss-row ss-large">
                            <div class="ss-left">
                                <a href="" class="ss-circle ss-circle-43">Responsive Image Gallery with Thumbnail Carousel</a>
                            </div>
                            <div class="ss-right">
                                <h3>
                                    <span class="tbntoggle" id="tbn_43">WEEK : 43 Reading - Drawing Conclusion
                                        <div class="menu" id="menu43">
                                            <p> <u>บทเรียน</u></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=4707" >วิดีโอสรุปบทเรียน Week43 </a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=3989" >เนื้อหา Drawing Conclusion</a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=4603" >One Day One Sentence Video by Lucas</a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=4877" >เฉลยการบ้าน week42 และการบ้าน Week43</a></p>
                                        </div>
                                    </span>
                                </h3>
                            </div>
                        </div>';

    $exercise_1y[43] = '<div class="ss-row">
                            <div class="ss-left">
                                <h2 id="week44">Week</h2>
                            </div>
                            <div class="ss-right">
                                <h2>44</h2>
                            </div>
                        </div>
                        <div class="ss-row ss-large">
                            <div class="ss-left">
                                <h3>
                                    <span class="tbntoggle" id="tbn_44">WEEK : 44 Speaking - Making an Appointment & Reading - Reading Memos
                                        <div class="menu" id="menu44">
                                            <p> <u>บทเรียน</u></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=#" >วิดีโอสรุปบทเรียน Week44 </a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=2668" >เนื้อหา Making an Appointment</a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=2907" >เนื้อหา Reading Memos</a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=4606" >One Day One Sentence Video by Lucas</a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=4878" >เฉลยการบ้าน week43 และการบ้าน Week44</a></p>
                                        </div>
                                    </span>
                                </h3>
                            </div>
                            <div class="ss-right">
                                <a href="" class="ss-circle ss-circle-44"></a>
                            </div>
                        </div>';

    $exercise_1y[44] = '<div class="ss-row">
                            <div class="ss-left">
                                <h2 id="week45">Week</h2>
                            </div>
                            <div class="ss-right">
                                <h2>45</h2>
                            </div>
                        </div>
                        <div class="ss-row ss-large">
                            <div class="ss-left">
                                <a href="" class="ss-circle ss-circle-45">Responsive Image Gallery with Thumbnail Carousel</a>
                            </div>
                            <div class="ss-right">
                                <h3>
                                    <span class="tbntoggle" id="tbn_45">WEEK : 45 Speaking - Phone Conversation
                                        <div class="menu" id="menu45">
                                            <p> <u>บทเรียน</u></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=#" >วิดีโอสรุปบทเรียน Week45 </a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=2632" >เนื้อหา Phone Conversation</a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=4623" >One Day One Sentence Video by Lucas</a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=4908" >เฉลยการบ้าน week44 และการบ้าน Week45</a></p>
                                        </div>
                                    </span>
                                </h3>
                            </div>
                        </div>';

    $exercise_1y[45] = '
                        <div class="ss-row">
                            <div class="ss-left">
                                <h2 id="week46">Week</h2>
                            </div>
                            <div class="ss-right">
                                <h2>46</h2>
                            </div>
                        </div>
                        <div class="ss-row ss-large">
                            <div class="ss-left">
                                <h3>
                                    <span class="tbntoggle" id="tbn_46">WEEK : 46 Speaking - Careers & Job Interview / Occupations/ Careers
                                        <div class="menu" id="menu46">
                                            <p> <u>บทเรียน</u></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=4900" >วิดีโอสรุปบทเรียน Week46 </a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=4769" >เนื้อหา Careers & Job Interview</a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=4822" >One Day One Sentence Video by Lucas</a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=4909" >เฉลยการบ้าน week45 และการบ้าน Week46</a></p>
                                        </div>
                                    </span>
                                </h3>
                            </div>
                            <div class="ss-right">
                                <a href="" class="ss-circle ss-circle-46"></a>
                            </div>
                        </div>';

    $exercise_1y[46] = '<div class="ss-row">
                            <div class="ss-left">
                                <h2 id="week47">Week</h2>
                            </div>
                            <div class="ss-right">
                                <h2>47</h2>
                            </div>
                        </div>
                        <div class="ss-row ss-large">
                            <div class="ss-left">
                                <a href="" class="ss-circle ss-circle-47">Responsive Image Gallery with Thumbnail Carousel</a>
                            </div>
                            <div class="ss-right">
                                <h3>
                                    <span class="tbntoggle" id="tbn_47">WEEK : 47 Vocabulary - American & British English
                                        <div class="menu" id="menu47">
                                            <p> <u>บทเรียน</u></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=#" >วิดีโอสรุปบทเรียน Week47 </a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=4783" >เนื้อหา American & British English</a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=#" >One Day One Sentence Video by Lucas</a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=4910" >เฉลยการบ้าน week46 และการบ้าน Week47</a></p>
                                        </div>
                                    </span>
                                </h3>
                            </div>
                        </div>';

    $exercise_1y[47] = '<div class="ss-row">
                            <div class="ss-left">
                                <h2 id="week48">Week</h2>
                            </div>
                            <div class="ss-right">
                                <h2>48</h2>
                            </div>
                        </div>
                        <div class="ss-row ss-large">
                            <div class="ss-left">
                                <h3>
                                    <span class="tbntoggle" id="tbn_48">WEEK : 48 Writing - Basic Writing Essay
                                        <div class="menu" id="menu48">
                                            <p> <u>บทเรียน</u></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=#" >วิดีโอสรุปบทเรียน Week48 </a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=3172" >เนื้อหา Basic Writing Essay</a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=#" >One Day One Sentence Video by Lucas</a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=4911" >เฉลยการบ้าน week47 และการบ้าน Week48</a></p>
                                        </div>
                                    </span>
                                </h3>
                            </div>
                            <div class="ss-right">
                                <a href="" class="ss-circle ss-circle-48"></a>
                            </div>
                        </div>';

    $exercise_1y[48] = '<div class="ss-row">
                            <div class="ss-left">
                                <h2 id="week49">Week</h2>
                            </div>
                            <div class="ss-right">
                                <h2>49</h2>
                            </div>
                        </div>
                        <div class="ss-row ss-large">
                            <div class="ss-left">
                                <a href="" class="ss-circle ss-circle-49">Responsive Image Gallery with Thumbnail Carousel</a>
                            </div>
                            <div class="ss-right">
                                <h3>
                                    <span class="tbntoggle" id="tbn_49">WEEK : 49 Writing - Writing a Resume 
                                        <div class="menu" id="menu49">
                                            <p> <u>บทเรียน</u></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=#" >วิดีโอสรุปบทเรียน Week49 </a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=3159" >เนื้อหา Writing a Resume</a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=#" >One Day One Sentence Video by Lucas</a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=4912" >เฉลยการบ้าน week48 และการบ้าน Week49</a></p>
                                        </div>
                                    </span>
                                </h3>
                            </div>
                        </div>';

    $exercise_1y[49] = '<div class="ss-row">
                            <div class="ss-left">
                                <h2 id="week50">Week</h2>
                            </div>
                            <div class="ss-right">
                                <h2>50</h2>
                            </div>
                        </div>
                        <div class="ss-row ss-large">
                            <div class="ss-left">
                                <h3>
                                    <span class="tbntoggle" id="tbn_50">WEEK : 50 Writing - Story of writing
                                        <div class="menu" id="menu50">
                                            <p> <u>บทเรียน</u></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=#" >วิดีโอสรุปบทเรียน Week50 </a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=4528" >เนื้อหา Parallel structure</a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=#" >One Day One Sentence Video by Lucas</a></p>
                                            <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=4914" >เฉลยการบ้าน week49 และการบ้าน Week50</a></p>
                                        </div>
                                    </span>
                                </h3>
                            </div>
                            <div class="ss-right">
                                <a href="" class="ss-circle ss-circle-50"></a>
                            </div>
                        </div>';

    $exercise_1y[50] = '<div class="ss-row">
                            <div class="ss-left">
                                <h2 id="week51">Week</h2>
                            </div>
                            <div class="ss-right">
                                <h2>51</h2>
                            </div>
                        </div>
                        <div class="ss-row ss-large">
                            <div class="ss-left">
                                <a href="" class="ss-circle ss-circle-51">Responsive Image Gallery with Thumbnail Carousel</a>
                            </div>
                            <div class="ss-right">
                                <h3>
                                    <span class="tbntoggle" id="tbn_51">WEEK : 51 Writing - Coherence & Cohesion
                                    <div class="menu" id="menu51">
                                        <p> <u>บทเรียน</u></p>
                                        <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=#" >วิดีโอสรุปบทเรียน Week51 </a></p>
                                        <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=4658" >เนื้อหา Writing an Email</a></p>
                                        <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=3163" >เนื้อหา Writing a Letter</a></p>
                                        <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=#" >One Day One Sentence Video by Lucas</a></p>
                                        <p class="fontsub"><a href="../1yc/1yearcontent.php?topic_id=4915" >เฉลยการบ้าน week50 และการบ้าน Week51</a></p>
                                    </div>
                                    </span>
                                </h3>
                            </div>
                        </div>';

    $exercise_1y[51] = '<div class="ss-row">
                            <div class="ss-left">
                                <h2 id="week52">Week</h2>
                            </div>
                            <div class="ss-right">
                                <h2>52</h2>
                            </div>
                        </div>
                        <div class="ss-row ss-large">
                            <div class="ss-left">
                                <h3>
                                    <span class="tbntoggle" id="tbn_52">Test : Final Test
                                        <div class="menu" id="menu52">
                                            <p ><a href="../1yc/1yearcontent.php?topic_id=3353" > Final Test</a></p>
                                        </div>
                                    </span>
                                </h3>
                            </div>
                            <div class="ss-right">
                                <a href="" class="ss-circle ss-circle-52"></a>
                            </div>
                        </div>
                    </div>';

    for ($i = 0; $i <= $lucid; $i++) {
        echo $exercise_1y[$i];
    }
    echo '  <div class="ss-row">
                <div class="ss-left">
                    <h2 id="">Next</h2>
                </div>
                <div class="ss-right">
                    <h2>WEEK</h2>
                </div>
            </div>';
    for ($w = $lucid + 1; $w < sizeof($weektopic); $w++) {
        echo $weektopic[$w];
    }

}
?>