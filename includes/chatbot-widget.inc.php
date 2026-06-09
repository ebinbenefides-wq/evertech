<?php
// EverBot chat widget — shared across all site sections.
// The including file must define $ebApiUrl and $ebLeadUrl before including this.
if (!isset($ebApiUrl))  $ebApiUrl  = 'chatbot-api.php';
if (!isset($ebLeadUrl)) $ebLeadUrl = 'chatbot-lead.php';
?>
<!-- EverBot AI Chat Widget -->
<style>
#eb-widget{position:fixed;bottom:100px;right:20px;z-index:9999;font-family:Arial,sans-serif}
#eb-toggle{width:55px;height:55px;border-radius:50%;background:linear-gradient(135deg,#7141B1,#43BAFF);border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;box-shadow:0 4px 15px rgba(113,65,177,.4);transition:transform .3s;position:relative}
#eb-toggle:hover{transform:scale(1.1)}
#eb-dot{position:absolute;top:2px;right:2px;width:12px;height:12px;background:#22c55e;border-radius:50%;border:2px solid #fff}
#eb-win{position:absolute;bottom:70px;right:0;width:340px;height:540px;background:#f8fafc;border-radius:16px;box-shadow:0 10px 40px rgba(0,0,0,.2);display:flex;flex-direction:column;overflow:hidden}
#eb-hdr{background:linear-gradient(135deg,#7141B1,#43BAFF);padding:14px 16px;display:flex;align-items:center;gap:10px;flex-shrink:0}
#eb-av{width:36px;height:36px;background:rgba(255,255,255,.25);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:700;color:#fff;flex-shrink:0}
#eb-hname{font-weight:700;font-size:14px;color:#fff}
#eb-hstatus{font-size:11px;color:rgba(255,255,255,.85)}
#eb-hclose{margin-left:auto;background:none;border:none;color:rgba(255,255,255,.7);font-size:20px;cursor:pointer;padding:0;line-height:1}
#eb-hclose:hover{color:#fff}
.eb-panel{display:none;flex-direction:column;flex:1;min-height:0;overflow:hidden}
.eb-panel.active{display:flex}
#eb-home-inner{overflow-y:auto;flex:1}
#eb-home-banner{background:linear-gradient(135deg,#7141B1,#43BAFF);padding:6px 20px 36px}
#eb-home-banner p{color:rgba(255,255,255,.85);font-size:15px;margin:0 0 2px}
#eb-home-banner h2{color:#fff;font-size:21px;font-weight:700;margin:0}
.eb-cards{padding:14px;margin-top:-22px;display:flex;flex-direction:column;gap:10px}
.eb-card{background:#fff;border:1px solid #eef0f2;border-radius:14px;padding:13px 15px;display:flex;align-items:center;justify-content:space-between;cursor:pointer;transition:background .15s;box-shadow:0 1px 4px rgba(0,0,0,.07);text-align:left;width:100%;font:inherit}
.eb-card:hover{background:#f5f3ff}
.eb-card-label{font-weight:600;font-size:13px;color:#1e293b}
.eb-card-sub{font-size:11px;color:#94a3b8;margin-top:2px}
.eb-status{display:flex;align-items:flex-start;gap:10px;cursor:default}
.eb-status:hover{background:#fff}
.eb-status-icon{width:22px;height:22px;border-radius:50%;background:#22c55e;display:flex;align-items:center;justify-content:center;flex-shrink:0;margin-top:1px}
#eb-msglist{flex:1;overflow-y:auto;padding:14px;display:flex;flex-direction:column;gap:10px;background:#f8fafc;min-height:0}
.eb-msg{display:flex;flex-direction:column;max-width:100%}
.eb-msg.user{align-items:flex-end}
.eb-msg.bot{align-items:flex-start}
.eb-bubble{max-width:80%;padding:10px 14px;border-radius:16px;font-size:13px;line-height:1.5;word-break:break-word}
.eb-msg.bot .eb-bubble{background:#fff;color:#333;border-bottom-left-radius:4px;box-shadow:0 1px 3px rgba(0,0,0,.08)}
.eb-msg.user .eb-bubble{background:linear-gradient(135deg,#7141B1,#43BAFF);color:#fff;border-bottom-right-radius:4px}
.eb-opts{display:flex;flex-wrap:wrap;gap:6px;margin-top:6px;max-width:90%}
.eb-opt{font-size:12px;padding:5px 12px;background:#fff;border:1px solid #d8b4fe;color:#7141B1;border-radius:20px;cursor:pointer;transition:all .15s;font:inherit}
.eb-opt:hover:not(:disabled){background:#f5f3ff;border-color:#7141B1}
.eb-opt:disabled{opacity:.4;cursor:default}
.eb-dots{display:inline-flex;gap:4px;align-items:center;height:14px}
.eb-dots .eb-dot{width:6px;height:6px;background:#bbb;border-radius:50%;animation:ebBounce 1.2s infinite;display:inline-block}
.eb-dots .eb-dot:nth-child(2){animation-delay:.2s}
.eb-dots .eb-dot:nth-child(3){animation-delay:.4s}
@keyframes ebBounce{0%,60%,100%{transform:translateY(0)}30%{transform:translateY(-6px)}}
#eb-inputarea{padding:10px 12px;background:#fff;border-top:1px solid #e2e8f0;display:flex;gap:8px;align-items:center;flex-shrink:0}
#eb-input{flex:1;border:1px solid #e2e8f0;border-radius:20px;padding:8px 14px;font-size:13px;outline:none;background:#f8fafc;font:inherit}
#eb-input:focus{border-color:#7141B1}
#eb-input:disabled{opacity:.6}
#eb-sendbtn{width:36px;height:36px;border-radius:50%;background:linear-gradient(135deg,#7141B1,#43BAFF);border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;flex-shrink:0}
#eb-sendbtn:disabled{opacity:.4;cursor:default}
#eb-help-inner{overflow-y:auto;flex:1;padding:14px;display:flex;flex-direction:column;gap:8px;background:#f8fafc}
#eb-help-inner h4{font-size:11px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;margin:0 0 2px}
.eb-faq{background:#fff;border-radius:14px;padding:13px 14px;border:1px solid #eef0f2;box-shadow:0 1px 4px rgba(0,0,0,.05);cursor:pointer}
.eb-faq:hover{border-color:#d8b4fe}
.eb-faq-q{font-weight:600;font-size:13px;color:#1e293b}
.eb-faq-a{font-size:12px;color:#64748b;margin-top:6px;line-height:1.5;display:none}
.eb-faq.open .eb-faq-a{display:block}
#eb-nav{background:#fff;border-top:1px solid #e2e8f0;display:flex;flex-shrink:0}
.eb-navbtn{flex:1;padding:9px 0;display:flex;flex-direction:column;align-items:center;gap:2px;font-size:11px;font-weight:500;color:#94a3b8;background:none;border:none;cursor:pointer;transition:color .15s;font:inherit}
.eb-navbtn.active{color:#7141B1}
.eb-navbtn svg{width:18px;height:18px}
@media (max-width:420px){#eb-win{width:92vw;right:-12px}}
</style>

<div id="eb-widget">
    <button id="eb-toggle" onclick="ebToggle()" title="Chat with EverBot">
        <svg id="eb-icon-chat" width="24" height="24" viewBox="0 0 24 24" fill="white"><path d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm-2 12H6v-2h12v2zm0-3H6V9h12v2zm0-3H6V6h12v2z"/></svg>
        <svg id="eb-icon-close" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" style="display:none"><path d="M18 6L6 18M6 6l12 12"/></svg>
        <span id="eb-dot"></span>
    </button>

    <div id="eb-win" style="display:none">
        <div id="eb-hdr">
            <div id="eb-av">ET</div>
            <div style="flex:1;min-width:0">
                <div id="eb-hname">EverBot</div>
                <div id="eb-hstatus">&#9679; Online</div>
            </div>
            <button id="eb-hclose" onclick="ebToggle()" aria-label="Close">&#10005;</button>
        </div>

        <!-- HOME -->
        <div class="eb-panel active" id="eb-tab-home">
            <div id="eb-home-inner">
                <div id="eb-home-banner">
                    <p>Hi there &#128075;</p>
                    <h2>How can we help?</h2>
                </div>
                <div class="eb-cards">
                    <div class="eb-card eb-status">
                        <div class="eb-status-icon">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                        </div>
                        <div>
                            <div class="eb-card-label">All Systems Operational</div>
                            <div class="eb-card-sub">EverBot is running normally</div>
                        </div>
                    </div>
                    <button class="eb-card" onclick="ebGoMessages()">
                        <div>
                            <div class="eb-card-label">Send us a message</div>
                            <div class="eb-card-sub">We typically reply instantly</div>
                        </div>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#7141B1" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
                    </button>
                    <button class="eb-card" onclick="ebQuick('Get a quote')">
                        <div class="eb-card-label">Get a quote</div>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
                    </button>
                    <button class="eb-card" onclick="ebQuick('Talk to an agent')">
                        <div class="eb-card-label">Talk to an agent</div>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
                    </button>
                    <button class="eb-card" onclick="ebSetTab('help')">
                        <div class="eb-card-label">FAQs</div>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- MESSAGES -->
        <div class="eb-panel" id="eb-tab-messages">
            <div id="eb-msglist"></div>
            <div id="eb-inputarea">
                <input type="text" id="eb-input" placeholder="Type your message..." onkeypress="if(event.key==='Enter')ebSend()">
                <button id="eb-sendbtn" onclick="ebSend()" aria-label="Send">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="white"><path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"/></svg>
                </button>
            </div>
        </div>

        <!-- HELP -->
        <div class="eb-panel" id="eb-tab-help">
            <div id="eb-help-inner"></div>
        </div>

        <div id="eb-nav">
            <button class="eb-navbtn active" id="ebnav-home" onclick="ebSetTab('home')">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                Home
            </button>
            <button class="eb-navbtn" id="ebnav-messages" onclick="ebSetTab('messages')">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
                Messages
            </button>
            <button class="eb-navbtn" id="ebnav-help" onclick="ebSetTab('help')">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Help
            </button>
        </div>
    </div>
</div>

<script>
(function(){
var ebApiUrl  = '<?php echo addslashes($ebApiUrl); ?>';
var ebLeadUrl = '<?php echo addslashes($ebLeadUrl); ?>';

var ebOpen      = false;
var ebTab       = 'home';
var ebHistory   = [];
var ebStreaming = false;
var ebLeadStage = 'idle'; // idle | name | email | phone | done
var ebLead      = {name:'', email:'', phone:''};
var ebMsgId     = 1;

var ebMessages = [
    {id:0, role:'bot', text:"Hi! I'm EverBot, Evertech's AI assistant. How can I help you today?", options:["Our Services","Get a quote","Talk to an agent","FAQs"]}
];

var ebFaqs = [
    {q:"What services does Evertech offer?", a:"We provide IT services (network infrastructure, virtualization, data center & cloud, managed IT, AMC), cybersecurity solutions (security assurance, DFIR, awareness training, password management), and more — including CCTV installation, website development, and software solutions."},
    {q:"Do you offer cybersecurity services?", a:"Yes — Security Assurance Solutions, Security Consultancy, Awareness Trainings, Password Management, Digital Forensics & Incident Response (DFIR), and CCTV Security Risk Assessment."},
    {q:"Where are your offices located?", a:"Dubai (Office 105, Ithraa Tower, Al Garhoud), London (71-75 Shelton Street, Covent Garden), and Bengaluru, India (BeHive, HSR Layout)."},
    {q:"How can I contact Evertech?", a:"Call +971 4 3487849, email info@evertechme.com, or just keep chatting here — we'll connect you with the team."},
    {q:"What is an Annual Maintenance Contract (AMC)?", a:"An AMC is an ongoing IT support agreement covering regular maintenance, monitoring and quick issue resolution — keeping your systems running smoothly year-round."},
    {q:"How do I get a quote?", a:"Click \"Get a quote\" in this chat, or email info@evertechme.com / call +971 4 3487849. We usually respond within 24 hours."}
];

function ebToggle() {
    ebOpen = !ebOpen;
    document.getElementById('eb-win').style.display = ebOpen ? 'flex' : 'none';
    document.getElementById('eb-icon-chat').style.display  = ebOpen ? 'none' : 'block';
    document.getElementById('eb-icon-close').style.display = ebOpen ? 'block' : 'none';
    if (ebOpen) {
        ebRenderMessages();
        if (ebTab === 'messages') document.getElementById('eb-input').focus();
    }
}

function ebSetTab(tab) {
    ebTab = tab;
    ['home','messages','help'].forEach(function(t){
        var panel = document.getElementById('eb-tab-' + t);
        var nav   = document.getElementById('ebnav-' + t);
        if (panel) panel.classList.toggle('active', t === tab);
        if (nav)   nav.classList.toggle('active', t === tab);
    });
    if (tab === 'messages') {
        ebRenderMessages();
        setTimeout(function(){ var i = document.getElementById('eb-input'); if(i) i.focus(); }, 50);
    }
    if (tab === 'help') ebRenderFaqs();
}

function ebGoMessages() { ebSetTab('messages'); }

function ebQuick(text) {
    ebGoMessages();
    setTimeout(function(){
        ebAppendMsg({id: ebMsgId++, role:'user', text:text});
        ebProcessInput(text);
    }, 60);
}

function ebSend() {
    var input = document.getElementById('eb-input');
    var value = input.value.trim();
    if (!value || ebStreaming) return;
    input.value = '';
    ebAppendMsg({id: ebMsgId++, role:'user', text:value});
    ebProcessInput(value);
}

function ebProcessInput(value) {
    var lower = value.toLowerCase();

    if (ebLeadStage !== 'idle' && ebLeadStage !== 'done') {
        ebHandleLead(value);
        return;
    }

    if (ebLeadStage === 'done' && (lower.indexOf('yes') !== -1 || lower.indexOf('more question') !== -1)) {
        ebLeadStage = 'idle';
    }
    if (ebLeadStage === 'done' && (lower.indexOf('no') === 0 || lower.indexOf('no thanks') !== -1)) {
        ebAddBot("Thanks for chatting! Have a great day. Feel free to reach out anytime. 😊");
        return;
    }

    if (lower.indexOf('quote') !== -1 || lower.indexOf('talk to') !== -1 || lower.indexOf('agent') !== -1 || lower.indexOf('speak to') !== -1 || lower.indexOf('get started') !== -1) {
        ebStartLead(lower.indexOf('quote') !== -1 ? 'quote' : 'agent');
        return;
    }

    if (lower === 'faqs' || lower === 'faq') {
        ebSetTab('help');
        return;
    }

    ebSendToAI(value);
}

function ebAddBot(text, options) {
    ebAppendMsg({id: ebMsgId++, role:'bot', text:text, options:options});
}

function ebStartLead(type) {
    ebLeadStage = 'name';
    ebAddBot(type === 'quote'
        ? "I'd love to help you get a quote! First, what's your name?"
        : "I'll connect you with our team! What's your name?");
}

function ebHandleLead(value) {
    if (ebLeadStage === 'name') {
        ebLead.name = value;
        ebLeadStage = 'email';
        ebAddBot("Nice to meet you, " + value + "! What's your email address?");
    } else if (ebLeadStage === 'email') {
        if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value)) {
            ebAddBot("Please enter a valid email address (e.g. name@example.com).");
            return;
        }
        ebLead.email = value;
        ebLeadStage = 'phone';
        ebAddBot("And your phone number? (press Enter to skip)");
    } else if (ebLeadStage === 'phone') {
        ebLead.phone = value === ebLead.email ? '' : value;
        ebLeadStage = 'done';
        ebAddBot("Thank you, " + ebLead.name + "! Our team will reach out to you at " + ebLead.email + " shortly. Anything else I can help with?", ["Yes, I have more questions", "No, thanks!"]);
        fetch(ebLeadUrl, {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify(ebLead)
        }).catch(function(){});
    }
}

function ebSendToAI(text) {
    ebHistory.push({role:'user', content:text});
    var historySnap = ebHistory.slice(-10);

    var streamId = ebMsgId++;
    ebMessages.push({id: streamId, role:'bot', text:'', streaming:true});
    ebAppendStreamBubble(streamId);
    ebSetStreaming(true);

    var fullText = '';

    fetch(ebApiUrl, {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({message:text, history:historySnap, stream:true})
    })
    .then(function(res){
        if (!res.ok) {
            return res.text().then(function(t){
                var msg = 'Request failed';
                try { var j = JSON.parse(t); if (j.error) msg = j.error; } catch(e){}
                throw new Error(msg);
            });
        }
        if (!res.body || !res.body.getReader) {
            return res.json().then(function(data){
                fullText = data.reply || data.error || 'Sorry, I could not process that.';
                ebFinalizeStream(streamId, fullText, !data.error);
            });
        }
        var reader  = res.body.getReader();
        var decoder = new TextDecoder();
        function pump() {
            return reader.read().then(function(chunk){
                if (chunk.done) {
                    ebFinalizeStream(streamId, fullText, true);
                    return;
                }
                fullText += decoder.decode(chunk.value, {stream:true});
                ebUpdateStreamBubble(streamId, fullText);
                return pump();
            });
        }
        return pump();
    })
    .catch(function(err){
        ebFinalizeStream(streamId, err && err.message ? err.message : 'Sorry, I had trouble connecting. Please try again or email info@evertechme.com.', false);
    });
}

function ebSetStreaming(val) {
    ebStreaming = val;
    var status = document.getElementById('eb-hstatus');
    var input  = document.getElementById('eb-input');
    var btn    = document.getElementById('eb-sendbtn');
    if (status) status.innerHTML = val
        ? 'Typing<span class="eb-dots" style="margin-left:5px"><span class="eb-dot"></span><span class="eb-dot"></span><span class="eb-dot"></span></span>'
        : '&#9679; Online';
    if (input) { input.disabled = val; input.placeholder = val ? 'Waiting for response...' : 'Type your message...'; }
    if (btn) btn.disabled = val;
}

function ebAppendMsg(msg) {
    ebMessages.push(msg);
    var list = document.getElementById('eb-msglist');
    if (!list) return;
    list.appendChild(ebBuildMsgEl(msg));
    list.scrollTop = list.scrollHeight;
}

function ebAppendStreamBubble(id) {
    var list = document.getElementById('eb-msglist');
    if (!list) return;
    var el = document.createElement('div');
    el.className = 'eb-msg bot';
    el.id = 'ebmsg-' + id;
    el.innerHTML = '<div class="eb-bubble"><span class="eb-dots"><span class="eb-dot"></span><span class="eb-dot"></span><span class="eb-dot"></span></span></div>';
    list.appendChild(el);
    list.scrollTop = list.scrollHeight;
}

function ebUpdateStreamBubble(id, text) {
    var el = document.getElementById('ebmsg-' + id);
    if (!el) return;
    el.querySelector('.eb-bubble').innerHTML = ebEscape(text) || '<span class="eb-dots"><span class="eb-dot"></span><span class="eb-dot"></span><span class="eb-dot"></span></span>';
    var list = document.getElementById('eb-msglist');
    list.scrollTop = list.scrollHeight;
}

function ebFinalizeStream(id, text, ok) {
    ebSetStreaming(false);
    var el = document.getElementById('ebmsg-' + id);
    var idx = ebMessages.findIndex(function(m){ return m.id === id; });
    var options = ok ? ["Ask another question", "Get a quote", "Talk to an agent"] : ["Try again"];
    if (idx !== -1) { ebMessages[idx].text = text; ebMessages[idx].streaming = false; ebMessages[idx].options = options; }
    if (el) {
        var html = '<div class="eb-bubble">' + ebEscape(text) + '</div>';
        html += ebBuildOptsHtml(options);
        el.innerHTML = html;
    }
    if (ok) ebHistory.push({role:'assistant', content: text});
    var list = document.getElementById('eb-msglist');
    if (list) list.scrollTop = list.scrollHeight;
}

function ebOptClick(btn, value) {
    var parent = btn.closest('.eb-msg');
    if (parent) {
        var btns = parent.querySelectorAll('.eb-opt');
        for (var i=0; i<btns.length; i++) { btns[i].disabled = true; }
    }
    ebAppendMsg({id: ebMsgId++, role:'user', text:value});
    ebProcessInput(value);
}
window.ebOptClick = ebOptClick;
window.ebToggle   = ebToggle;
window.ebSetTab   = ebSetTab;
window.ebGoMessages = ebGoMessages;
window.ebQuick    = ebQuick;
window.ebSend     = ebSend;

function ebBuildOptsHtml(options) {
    if (!options || !options.length) return '';
    var h = '<div class="eb-opts">';
    options.forEach(function(opt){
        h += '<button class="eb-opt" onclick="ebOptClick(this,' + ebAttrJson(opt) + ')">' + ebEscape(opt) + '</button>';
    });
    return h + '</div>';
}

function ebBuildMsgEl(msg) {
    var div = document.createElement('div');
    div.className = 'eb-msg ' + msg.role;
    div.id = 'ebmsg-' + msg.id;
    div.innerHTML = '<div class="eb-bubble">' + ebEscape(msg.text) + '</div>' + ebBuildOptsHtml(msg.options);
    return div;
}

function ebRenderMessages() {
    var list = document.getElementById('eb-msglist');
    if (!list) return;
    list.innerHTML = '';
    ebMessages.forEach(function(msg){
        if (msg.streaming) return;
        list.appendChild(ebBuildMsgEl(msg));
    });
    list.scrollTop = list.scrollHeight;
}

function ebRenderFaqs() {
    var inner = document.getElementById('eb-help-inner');
    if (!inner || inner.children.length) return;
    var h = '<h4>Quick Answers</h4>';
    ebFaqs.forEach(function(faq, i){
        h += '<div class="eb-faq" id="ebfaq-' + i + '" onclick="ebToggleFaq(' + i + ')">'
           + '<div class="eb-faq-q">' + ebEscape(faq.q) + '</div>'
           + '<div class="eb-faq-a">' + ebEscape(faq.a) + '</div></div>';
    });
    inner.innerHTML = h;
}

function ebToggleFaq(i) {
    var el = document.getElementById('ebfaq-' + i);
    if (el) el.classList.toggle('open');
}
window.ebToggleFaq = ebToggleFaq;

function ebEscape(t) {
    return String(t == null ? '' : t)
        .replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/\n/g,'<br>');
}
function ebAttrJson(t) {
    return JSON.stringify(String(t)).replace(/'/g, "\\'").replace(/"/g, '&quot;');
}
})();
</script>
