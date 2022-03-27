<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Voter Receipt</title>
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <link rel="stylesheet" href="../css/voter-receipt.css">
    <script type="text/javascript">
        WebFont.load({
            google: {
                families: ["Montserrat:100,100italic,200,200italic,300,300italic,400,400italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic"]
            }
        });
    </script>

</head>

<body>

    <div class="section wf-section">
        <div class="div-block-11">
            <div class="text-block-2"></div>
            <div class="text-block-2">Thank you &lt;name&gt; for voting! <br />This is to confirm that your vote has been recorded.<br />Here is your vote receipt for ELECTION AY: &lt;year&gt; - &lt;year&gt;.</div>
        </div>
        <div class="div-block-receipt">
            <div class="div-block-10"><img src="https://uploads-ssl.webflow.com/620664b6d7ce5347de433086/6236d1d3235142d0e742eaec_Black%20%26%20White%20Minimal%20Bold%20AV%20%26%20Co%20Company%20Service%20Logo.jpg" loading="lazy" width="46" alt="" class="image-ovslogo" />
                <h1 class="heading-3">VOTE RECEIPT</h1>
            </div>
            <!-- <img src="https://uploads-ssl.webflow.com/620664b6d7ce5347de433086/6236d994c938ba50fedf046b_21.SO-sits.png" loading="lazy" width="84" sizes="84px" srcset="https://uploads-ssl.webflow.com/620664b6d7ce5347de433086/6236d994c938ba50fedf046b_21.SO-sits-p-500.png 500w, https://uploads-ssl.webflow.com/620664b6d7ce5347de433086/6236d994c938ba50fedf046b_21.SO-sits-p-800.png 800w, https://uploads-ssl.webflow.com/620664b6d7ce5347de433086/6236d994c938ba50fedf046b_21.SO-sits-p-1080.png 1080w, https://uploads-ssl.webflow.com/620664b6d7ce5347de433086/6236d994c938ba50fedf046b_21.SO-sits.png 1500w" alt="" class="image-ovslogo" /> -->
            <div class="div-header-wrap">
                <div class="div-header_left">
                    <p class="votername">&lt;Voter Name&gt;</p>
                    <p class="voter-id">&lt;Voter ID No. &gt;</p>
                    <div>&lt;Ballot No.&gt;</div>
                </div>
                <div class="div-header_right">
                    <p class="paragraph">&lt;Date&gt; | &lt;Time&gt;<br />Society of Information Technology Students</p>
                </div>
            </div>
            <div id="divider" ></div>
            
            <div class="text-block-divider"> START OF BALLOT </div>
            <div class="w-layout-grid grid-ballot">
                <h4 id="w-node-ae92d651-2aa7-92c7-b7b4-a4ff582eb1da-b6433089" class="position-label">President :</h4>
                <div id="w-node-_19e3133e-30d5-a295-3b38-70759a789540-b6433089" class="candidate-name">&lt;name of candidate&gt;</div>
                <h4 id="w-node-_86652443-7606-8212-1eda-89545698d59a-b6433089" class="position-label">Vice - President :</h4>
                <div id="w-node-f0b8a916-2235-1ef6-86c7-06b4f37b9a78-b6433089" class="candidate-name">&lt;name of candidate&gt;</div>
                <h4 id="w-node-_76c13d0b-eee0-3bc7-8fa1-38d489b95796-b6433089" class="position-label">Secretary :</h4>
                <div id="w-node-_16b29507-274c-1954-657f-62fad7ed48d2-b6433089" class="candidate-name">&lt;name of candidate&gt;</div>
            </div>
            <div class="text-block-divider"> END OF BALLOT </div>
            <div id="divider" ></div>
            <div class="text-block">PLEASE KEEP THIS RECEIPT FOR REFERENCE OF YOUR BALLOT.</div>
            <div class="text-block-4">powered by OVS email</div>
        </div>
    </div>
</body>

</html>