<!DOCTYPE html>
<html lang="en">
<head>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Artieses</title>
  <link rel="stylesheet" href="{{ asset('css/appes/appes.css') }}">
  <link rel="stylesheet" href="{{ asset('css/appes/artiekeles.css') }}">
  <link rel="stylesheet" href="{{ asset('css/appes/artievides.css') }}">
  <link rel="stylesheet" href="{{ asset('css/appes/artiestories.css') }}">
  <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
  <link rel="icon" href="{{ asset('partses/favicon.ico') }}">
  @include('partses.baries')
</head>
<body class="dark-mode">
  @if(session('alert'))
    <div class="feedback error">
    </div>
  @endif
  <div class="card-main">
    <div class="wrapper">
        @foreach ($mergedFeed as $item)
            @if ($item['type'] === 'video')
            @php $video = $item['data']; @endphp
            <div class="card-artievides1 card-artievides1{{ $video->codevides }}" id="card-artievides1{{ $video->codevides }}">
                @include('appes.artievides.artievides', ['video' => $item['data']])
            </div>
            @elseif ($item['type'] === 'story')
            @php $story = $item['data']; @endphp
                @include('appes.artiestories.artiestories', ['story' => $item['data']])
                @include('appes.artiestories.js.commentjs')
            @elseif ($item['type'] === 'article')
            @php $article = $item['data']; @endphp
                    <h3>{{ $item['data']->judul }}</h3>
                    <p>{{ Str::limit(strip_tags($item['data']->konten), 100) }}</p>
            @endif
        @endforeach
    </div>
  </div>
</body>
  <script src="{{ asset('js/appes/togglemode.js') }}"></script>
  <script src="{{ asset('js/appes/artievides1.js') }}"></script>
  <script>
    const originalLog = console.log;
    console.log = function (...args) {
      if (args.some(arg => typeof arg === 'string' && arg.includes('Pusher')) ||
          args.some(arg => typeof arg === 'string' && arg.includes('broadcast.typing1')) || 
          args.some(arg => typeof arg === 'string' && arg.includes('user.typing1')) ||
          args.some(arg => typeof arg === 'string' && arg.includes('Pusher1')) ||
          args.some(arg => typeof arg === 'string' && arg.includes('broadcast.typing')) ||
          args.some(arg => typeof arg === 'string' && arg.includes('user.typing'))) {
          return;
      }
      originalLog.apply(console, args);
    };        
  </script><!-- silent console-->
  <script>
    document.querySelectorAll('[id^="importbtn1-"]').forEach(importBtn1 => {
        const storyCode1 = importBtn1.id.replace('importbtn1-', '');
        const fileInput1 = document.getElementById('filepicker1-' + storyCode1);
        if (fileInput1) {
            importBtn1.addEventListener('click', () => {
                fileInput1.click();
            });
        }
        if (fileInput1 && !fileInput1.dataset.listenerAdded) {
            fileInput1.addEventListener('change', function () {
                const file1 = this.files[0];
                if (file1 && file1.type.startsWith('image/')) {
                    const reader1 = new FileReader();
                    reader1.onload = function (event) {
                        showImagePreview1(event.target.result, storyCode1);
                    };
                    reader1.readAsDataURL(file1);
                }
            });
            fileInput1.dataset.listenerAdded = 'true';
        }
        const input1 = document.getElementById('inpbalassaja-' + storyCode1);
        if (input1 && !input1.dataset.listenerAdded) {
            input1.addEventListener('paste', function (e) {
                const items = (e.clipboardData || e.originalEvent.clipboardData).items;
                for (let i = 0; i < items.length; i++) {
                    if (items[i].type.indexOf("image") === 0) {
                        const file = items[i].getAsFile();
                        const reader1 = new FileReader();
                        reader1.onload = function (event) {
                            showImagePreview1(event.target.result, storyCode1);
                        };
                        reader1.readAsDataURL(file);
                    }
                }
            });
            input1.dataset.listenerAdded = 'true';
        }
    });
    function showImagePreview1(imageSrc, storyCode1) {
        const oldPreview = document.querySelector('.image-preview1-' + storyCode1);
        if (oldPreview) oldPreview.remove();
        const preview = document.createElement('div');
        preview.className = 'image-preview1 image-preview1-' + storyCode1;
        preview.style.marginTop = '10px';
        preview.id = 'image-preview1-' + storyCode1;
        preview.style.textAlign = 'center';
        const img = document.createElement('img');
        img.src = imageSrc;
        img.style.height = '80px';
        img.style.borderRadius = '8px';
        img.style.boxShadow = '0 0 5px rgba(0,0,0,0.2)';
        const delimg = document.createElement('button');
        delimg.className = 'bcloimcom1 blcloimcom' + storyCode1;
        delimg.id = 'bcloimcom' + storyCode1;
        delimg.innerHTML = '&times;';
        delimg.style.cursor = 'pointer';
        delimg.addEventListener('click', () => { 
            preview.remove();
            const fileInput1 = document.getElementById('filepicker1-' + storyCode1);
            if (fileInput1) {
                fileInput1.value = '';
            }
        });
        preview.appendChild(img);
        preview.appendChild(delimg);
        const input1 = document.getElementById('inpbalassaja-' + storyCode1);
        if (input1) input1.value = "";
        const clearBtn1 = document.getElementById(`close-dibales-${storyCode1}`);
        if (clearBtn1) clearBtn1.classList.add('hidden');
        const sendBtn = document.getElementById('lagi-' + storyCode1);
        if (sendBtn && sendBtn.parentNode) {
            sendBtn.insertBefore(preview, sendBtn.firstChild);
        }
    }
  </script><!-- preview img balascomment -->
  <script>
    function handleSendComment(buttonElement) {
        if (buttonElement.disabled) return;
        const targetid = buttonElement.id.replace('btnimg-sendcom-', '');
        const inputOL = document.getElementById(`inpbalassaja-${targetid}`);
        const commentses1 = document.getElementById(`inpbalassajahidden-${targetid}`);
        const fileInput1 = document.getElementById(`filepicker1-${targetid}`);
        const clearBtn1 = document.getElementById(`close-dibales-${targetid}`);
        const delprev1 = document.getElementById(`image-preview1-${targetid}`);
        const message1 = inputOL.value.trim();
        const storyCode1 = commentses1.value.trim();
        const hasImage = fileInput1?.files.length > 0;
        if (!hasImage && message1.length === 0) {
            return;
        }
        buttonElement.disabled = true;
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
        const handleAuthRedirect = (data) => {
            if (!data.logged_in) {
                sessionStorage.setItem('alert', data.alert);
                sessionStorage.setItem('form', data.form);
                window.location.href = data.redirect;
                return true;
            }
            return false;
        };
        const restoreButton = () => {
            setTimeout(() => {
                buttonElement.disabled = false;
            }, 300);
        };
        if (hasImage) {
            const formData = new FormData();
            formData.append('storyCode1', storyCode1);
            formData.append('code', targetid);
            formData.append('message1', message1);
            formData.append('fileInput1', fileInput1.files[0]);
            fetch('/enter-typing1', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (handleAuthRedirect(data)) return;
                inputOL.value = '';
                fileInput1.value = '';
                delprev1?.remove();
                clearBtn1?.classList.add('hidden');
            })
            .catch(error => console.error('Error:', error))
            .finally(restoreButton);
        } else if (message1.length > 0) {
            fetch('/enter-typing1', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ message1, storyCode1 })
            })
            .then(res => res.json())
            .then(data => {
                if (handleAuthRedirect(data)) return;
                inputOL.value = '';
                clearBtn1?.classList.add('hidden');
            })
            .catch(error => console.error('Error:', error))
            .finally(restoreButton);
        } else {
            restoreButton();
        }
    }
    document.addEventListener('click', function(event) {
        const sendButton = event.target.closest('[id^="btnimg-sendcom-"]');
        if (sendButton) {
            event.preventDefault();
            handleSendComment(sendButton);
            return;
        }
        const clearButton = event.target.closest('[id^="close-dibales-"]');
        if (clearButton) {
            event.preventDefault();
            const targetid = clearButton.id.replace('close-dibales-', '');
            const inputOL = document.getElementById(`inpbalassaja-${targetid}`);
            if (inputOL) {
                inputOL.value = "";
                clearButton.classList.add('hidden');
                inputOL.focus();
            }
        }
    });
    document.addEventListener('focusin', function(event) {
        const inputOL = event.target;
        if (!inputOL.id || !inputOL.id.startsWith('inpbalassaja-')) return;
        if (inputOL.dataset.listenersAttached) return;
        const targetid = inputOL.id.replace('inpbalassaja-', '');
        const clearBtn1 = document.getElementById(`close-dibales-${targetid}`);
        const commentses1 = document.getElementById(`inpbalassajahidden-${targetid}`);
        let typingTimeout = null;
        inputOL.addEventListener('input', () => {
            clearBtn1?.classList.toggle('hidden', inputOL.value.trim().length === 0);
            clearTimeout(typingTimeout);
            typingTimeout = setTimeout(() => {
            }, 500);
        });
        inputOL.addEventListener('keydown', (e) => {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                const sendButton = document.getElementById(`btnimg-sendcom-${targetid}`);
                if (sendButton) {
                    handleSendComment(sendButton);
                }
            }
        });
        inputOL.dataset.listenersAttached = 'true';
    });
  </script><!-- fetch dan broadcast chat balas comment-->
  <script>
    if (typeof window.pusher1 === 'undefined') {
        window.pusher1 = new Pusher("{{ config('broadcasting.connections.pusher.key') }}", {
            cluster: "{{ config('broadcasting.connections.pusher.options.cluster') }}",
            forceTLS: true
        });
    }
    if (typeof window.channel3 === 'undefined') {
        window.channel3 = window.pusher1.subscribe('typing-channel1');
    }
    window.typingTimeout3 = null;
    window.canFetchTyping3 = true;
    window.channel3.bind('user.typing1', function (data) {
        if (data.message && data.message !== "") {
            if (window.canFetchTyping3) {
                const imprev = document.getElementById(`image-preview1-${data.reqplat}`);
                if(imprev) imprev.remove();
                window.canFetchTyping3 = false;
                const reply = document.createElement('div');
                reply.className = `reply reply-${data.reqplat}`;
                const aprofil = document.createElement('a');
                aprofil.href = `/profiles/${data.username}`;
                const imgprofil = document.createElement('img');
                imgprofil.src = `${data.username}/profil/${data.improfil}`;
                imgprofil.className = `creatorstories`;
                const dispcard = document.createElement('div');
                dispcard.className = 'dispcard';
                const aname = document.createElement('a');
                aname.href = `/profiles/${data.username}`;
                const nameprofil = document.createElement('p');
                nameprofil.className = `dispname`;
                nameprofil.innerText = data.username;
                const messageprof = document.createElement('p');
                messageprof.className = `comment001`;
                const tempDiv = document.createElement("div");
                tempDiv.innerHTML = data.message;
                const imgElement = tempDiv.querySelector('img.imgcom');
                if (imgElement) {
                    messageprof.innerHTML = data.message;
                } else {
                    messageprof.innerText = tempDiv.innerText;
                }
                const wrappercom3 = document.createElement('div');
                wrappercom3.className = `wrappercom3 wrappercom3-${data.reqplat}`;
                const reacted = document.createElement('div');
                reacted.className = `srcard4 srcard5-${data.comstoriesid} hidden`;
                reacted.id = `srcard5-${data.comstoriesid}`;
                const reacted1 = document.createElement('a');
                reacted1.href = `javascript:void(0)`;
                const reacted2 = document.createElement('a');
                reacted2.href = `javascript:void(0)`;
                const reacted3 = document.createElement('a');
                reacted3.href = `javascript:void(0)`;
                const reacted4 = document.createElement('a');
                reacted4.href = `javascript:void(0)`;
                const reacted5 = document.createElement('a');
                reacted5.href = `javascript:void(0)`;
                const reactedimg1 = document.createElement('img');
                reactedimg1.src = '{{ asset('partses/reaksi/suka.png') }}';
                reactedimg1.className = `iclikestory reaksi-btn4-${data.comstoriesid}`;
                reactedimg1.setAttribute('data-reaksi4', 'suka');
                reactedimg1.setAttribute('data-artiestoriesid4', `${data.comstoriesid}`);
                const reactedimg2 = document.createElement('img');
                reactedimg2.src = '{{ asset('partses/reaksi/suka.png') }}';
                reactedimg2.className = `iclikestory reaksi-btn4-${data.comstoriesid}`;
                reactedimg2.setAttribute('data-reaksi4', 'suka');
                reactedimg2.setAttribute('data-artiestoriesid4', `${data.comstoriesid}`);
                const reactedimg3 = document.createElement('img');
                reactedimg3.src = '{{ asset('partses/reaksi/suka.png') }}';
                reactedimg3.className = `iclikestory reaksi-btn4-${data.comstoriesid}`;
                reactedimg3.setAttribute('data-reaksi4', 'suka');
                reactedimg3.setAttribute('data-artiestoriesid4', `${data.comstoriesid}`);
                const reactedimg4 = document.createElement('img');
                reactedimg4.src = '{{ asset('partses/reaksi/suka.png') }}';
                reactedimg4.className = `iclikestory reaksi-btn4-${data.comstoriesid}`;
                reactedimg4.setAttribute('data-reaksi4', 'suka');
                reactedimg4.setAttribute('data-artiestoriesid4', `${data.comstoriesid}`);
                const reactedimg5 = document.createElement('img');
                reactedimg5.src = '{{ asset('partses/reaksi/suka.png') }}';
                reactedimg5.className = `iclikestory reaksi-btn4-${data.comstoriesid}`;
                reactedimg5.setAttribute('data-reaksi4', 'suka');
                reactedimg5.setAttribute('data-artiestoriesid4', `${data.comstoriesid}`);
                const reactedp = document.createElement('p');
                reactedp.className = `rbtnry5-${data.comstoriesid}`;
                reactedp.id = `rbtnry5-${data.comstoriesid}`;
                reactedp.innerText = 'suka';
                const createdate = document.createElement('p');
                createdate.className = `captionStoriess gg2`;
                createdate.innerHTML = `${data.timeAgo}`;
                const getChat = document.getElementById(`lagi-${data.reqplat}`);
                const balas = document.getElementById(`seerpl11-${data.reqplat}`);
                const urungkan = document.getElementById(`seerpl01-${data.reqplat}`);
                reply.append(aprofil, dispcard);
                aprofil.appendChild(imgprofil);
                dispcard.append(aname,messageprof);
                aname.appendChild(nameprofil);
                wrappercom3.append(reacted, reactedp, createdate);
                reacted.append(reacted1, reacted2, reacted3, reacted4, reacted5);
                reacted1.appendChild(reactedimg1);
                reacted2.appendChild(reactedimg2);
                reacted3.appendChild(reactedimg3);
                reacted4.appendChild(reactedimg4);
                reacted5.appendChild(reactedimg5);
                const getreplies = document.getElementById(`seerpl2-${data.reqplat}`);
                if (!balas) {
                    const balas1 = document.getElementById(`balaskansaja-${data.reqplat}`);
                    const urungkan1 = document.getElementById(`urungkansaja-${data.reqplat}`);
                    const replies = document.createElement('div');
                    replies.className = `replies replies-${data.reqplat}`;
                    replies.id = `seerpl2-${data.reqplat}`;
                    const makebalaskan = document.createElement('p');
                    makebalaskan.className = `balaskan002`;
                    makebalaskan.id = `seerpl11-${data.reqplat}`;
                    makebalaskan.innerHTML = `Lihat(${data.jumlah})`;
                    const makeurungkan = document.createElement('p');
                    makeurungkan.className = `urungkan001`;
                    makeurungkan.id = `seerpl01-${data.reqplat}`;
                    makeurungkan.innerHTML = `Tutup(${data.jumlah})`;
                    if (balas1 && balas1.classList.contains('hidden')) {
                        makebalaskan.classList.add('hidden');
                    } else {
                        makeurungkan.classList.add('hidden');
                        replies.classList.add('hidden');
                    }
                    if (urungkan1) urungkan1.remove();
                    if (balas1) balas1.remove();
                    function waitForElement(selector, callback) {
                        const el = document.querySelector(selector);
                        if (el) {
                            callback(el);
                            return;
                        }
                        const observer = new MutationObserver((mutations, obs) => {
                            const el = document.querySelector(selector);
                            if (el) {
                                obs.disconnect();
                                callback(el);
                            }
                        });
                        observer.observe(document.body, { childList: true, subtree: true });
                    }
                    waitForElement(`#wrappercom2-${data.reqplat}`, (wrappercom2) => {
                        wrappercom2.appendChild(replies);
                        replies.append(reply, wrappercom3, getChat);
                        const getsuka = document.getElementById(`rbtnry3-${data.reqplat}`);
                        if (getsuka) getsuka.after(makebalaskan);
                        makebalaskan.after(makeurungkan);
                    });
                } if (balas) {
                    const makebalaskan = document.createElement('p');
                    makebalaskan.className = `balaskan002`;
                    makebalaskan.id = `seerpl11-${data.reqplat}`;
                    makebalaskan.innerHTML = `Lihat(${data.jumlah})`;
                    balas.replaceWith(makebalaskan);
                    if (urungkan) {
                        const makeurungkan = document.createElement('p');
                        makeurungkan.className = `urungkan001`;
                        makeurungkan.id = `seerpl01-${data.reqplat}`;
                        makeurungkan.innerHTML = `Tutup(${data.jumlah})`;
                        urungkan.replaceWith(makeurungkan);
                        if (getreplies && getreplies.classList.contains('hidden')) {
                            makeurungkan.classList.add('hidden');
                        } else {
                            makebalaskan.classList.add('hidden');
                        }
                        balas.replaceWith(makebalaskan);
                        getreplies.append(reply, wrappercom3, getChat);
                    };
                };
                getChat.classList.remove('hidden');
                clearTimeout(window.typingTimeout3);
                window.typingTimeout3 = setTimeout(() => {
                    window.canFetchTyping3 = true;
                }, 1000);
            }
        }
    });
    if (typeof window.channel4 === 'undefined') {
        window.channel4 = window.pusher1.subscribe('broadcast-channel1');
    }
    window.channel4.bind('broadcast.typing1', function (data) {
        if (data.reqplat && data.reqplat.length > 0) {
            const cardmengetik = document.getElementById(`divbrcmt2-${data.reqplat}`);
            const teksmengetik = document.getElementById(`brcmt2-${data.reqplat}`);
            cardmengetik.classList.remove('hidden');
            teksmengetik.innerText = `${data.username} sedang mengetik...`;
            clearTimeout(window.typingTimeouts?.[data.reqplat]);
            window.typingTimeouts = window.typingTimeouts || {};
            window.typingTimeouts[data.reqplat] = setTimeout(() => {
                teksmengetik.innerText = '';
                cardmengetik.classList.add('hidden');
            }, 4000);
        }
    });
  </script><!-- pusher broadcasting dan chat balas comment -->
  <script>
    document.querySelectorAll('[id^="inpcom-"]').forEach(inputEl => {
        const storyCode = inputEl.id.replace('inpcom-', '');
        const clearBtn = document.getElementById(`balinpcom-${storyCode}`);
        const sendBtn = document.getElementById(`sendcom-${storyCode}`);
        const commentses = document.getElementById(`commentses-${storyCode}`);
        let canSend = true;
        window.typingTimeout2 = null;
        window.canFetchTyping2 = true;
        window.typingTimeout5 = null;
        window.canFetchTyping5 = true;
        if (!commentses) return;
        inputEl.addEventListener('input', function () {
            if (inputEl.value.length > 0) {
                clearBtn?.classList.remove('hidden');
                clearBtn?.classList.add('block');
            } else {
                clearBtn?.classList.add('hidden');
                clearBtn?.classList.remove('block');
            }
            const message = inputEl.value.trim();
            const comentses = commentses.value.trim();
            if (window.canFetchTyping5) {
                window.canFetchTyping5 = false;
                fetch('/broadcast-typing', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ message, comentses })
                })
                .then(res => res.json())
                .then(data => {
                    if (!data.logged_in) {
                        sessionStorage.setItem('alert', data.alert);
                        sessionStorage.setItem('form', data.form);
                        window.location.href = data.redirect;
                    }
                });
                clearTimeout(window.typingTimeout5);
                window.typingTimeout5 = setTimeout(() => {
                    window.canFetchTyping5 = true;
                }, 1000);
            }
        });
        clearBtn?.addEventListener('click', function () {
            inputEl.value = "";
            clearBtn.classList.add('hidden');
        });
        function sendComment() {
            const message = inputEl.value.trim();
            const coderies = commentses.value.trim();
            const fileInput = document.getElementById(`filepicker-${storyCode}`);
            if (message.length === 0 && canSend && fileInput.files.length > 0) {
                canSend = false;
                if (window.canFetchTyping2) {
                    window.canFetchTyping2 = false;
                    const formData = new FormData();
                    formData.append('coderies', coderies);
                    formData.append('fileInput', fileInput.files[0]);
                    fetch('/enter-typing', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        fileInput.value = '';
                        const delprev = document.getElementById('image-preview-' + storyCode);
                        delprev.remove();
                        clearBtn?.classList.add('hidden');
                        if (!data.logged_in) {
                            sessionStorage.setItem('alert', data.alert);
                            sessionStorage.setItem('form', data.form);
                            window.location.href = data.redirect;
                        }
                    })
                    .finally(() => {
                        setTimeout(() => {
                            canSend = true;
                        }, 30);
                    });
                    clearTimeout(window.typingTimeout2);
                    window.typingTimeout2 = setTimeout(() => {
                        window.canFetchTyping2 = true;
                    }, 1000);
                }
            }
            if (message.length > 0 && canSend && fileInput.files.length === 0) {
                canSend = false;
                if (window.canFetchTyping2) {
                    window.canFetchTyping2 = false;
                    fetch('/enter-typing', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({ message, coderies })
                    })
                    .then(res => res.json())
                    .then(data => {
                        inputEl.value = '';
                        clearBtn?.classList.add('hidden');
                        if (!data.logged_in) {
                            sessionStorage.setItem('alert', data.alert);
                            sessionStorage.setItem('form', data.form);
                            window.location.href = data.redirect;
                        }
                    })
                    .finally(() => {
                        setTimeout(() => {
                            canSend = true;
                        }, 30);
                    });
                    clearTimeout(window.typingTimeout2);
                    window.typingTimeout2 = setTimeout(() => {
                        window.canFetchTyping2 = true;
                    }, 1000);
                }
            }
        }
        inputEl.addEventListener('keydown', function (event) {
            if (event.key === 'Enter') {
                event.preventDefault();
                sendComment();
            }
        });
        sendBtn?.addEventListener('click', function (event) {
            event.preventDefault();
            sendComment();
        });
    });
  </script><!-- fetch broadcasting dan chat awal comment -->
  <script>
      if (typeof window.pusher === 'undefined') {
          Pusher.logToConsole = true;
          window.pusher = new Pusher("{{ config('broadcasting.connections.pusher.key') }}", {
              cluster: "{{ config('broadcasting.connections.pusher.options.cluster') }}",
              forceTLS: true
          });
      }
      if (typeof window.channel === 'undefined') {
          window.channel = window.pusher.subscribe('typing-channel');
      }
      if (typeof window.channel1 === 'undefined') {
          window.channel1 = window.pusher.subscribe('broadcast-channel');
      }
      if (!window.channelBound1) {
          window.channel.bind('user.typing', function (data) {
              if (data.message && data.message !== "") {
                  const targetWrapper = document.querySelector(`.commentarist[data-story="${data.coderies}"]`);
                  check1 = targetWrapper.getAttribute('data-story');
                  if (data.coderies === check1) {
                    const container = document.getElementById(`wrappercom1-${check1}`);
                    const apusnoncmt = document.getElementById(`noncomments-${data.coderies}`);
                    if (apusnoncmt) {
                        apusnoncmt.remove();
                    }
                    const commentwrapcom001 = document.createElement('div');
                    commentwrapcom001.id = `commentwrapcom-${data.comstoriesid}`;
                    const card = document.createElement('div');
                    card.className = `cardcom001 cardcom001-${data.comstoriesid}`;
                    const aharen = document.createElement('a');
                    aharen.href = `/profiles/${data.username}`;
                    const aharen1 = document.createElement('a');
                    aharen1.href = `/profiles/${data.username}`;
                    const img = document.createElement('img');
                    img.src = `${data.username}/profil/${data.improfil}`;
                    img.className = 'creatorstories';
                    const dispcard = document.createElement('div');
                    dispcard.className = 'dispcard';
                    const ddispcanam = document.createElement('div');
                    ddispcanam.className = 'ddispcanam';
                    const pName = document.createElement('p');
                    pName.className = 'dispname';
                    pName.innerText = data.username;
                    const pComment = document.createElement('p');
                    pComment.className = 'comment001';
                    const tempDiv = document.createElement("div");
                    tempDiv.innerHTML = data.message;
                    if (tempDiv.querySelector('img.imgcom')) {
                        pComment.innerHTML = data.message;
                    } else {
                        pComment.innerText = tempDiv.innerText;
                    }
                    const wrappercom2 = document.createElement('div');
                    wrappercom2.className = `wrappercom2 wrappercom2-${data.comstoriesid}`;
                    wrappercom2.id = `wrappercom2-${data.comstoriesid}`;
                    const balaskan001 = document.createElement('div');
                    balaskan001.className = `balaskan001`;
                    balaskan001.id = `balaskan001-${data.comstoriesid}`;
                    const suka = document.createElement('p');
                    suka.className = `inint rbtnry3-${data.comstoriesid}`;
                    suka.id = `rbtnry3-${data.comstoriesid}`;
                    suka.innerText = 'Suka';
                    const created = document.createElement('p');
                    created.className = 'captionStoriess gg12';
                    created.innerText = `${data.timeAgo}`;
                    const balaskan = document.createElement('p');
                    balaskan.className = `balaskan002 balaskansaja-${data.comstoriesid}`;
                    balaskan.id = `balaskansaja-${data.comstoriesid}`;
                    balaskan.innerText = 'Balas';
                    const urungkansaja = document.createElement('p');
                    urungkansaja.className = `urungkan001 urungkansaja-${data.comstoriesid} hidden`;
                    urungkansaja.id = `urungkansaja-${data.comstoriesid}`;
                    urungkansaja.innerText = 'Urungkan';
                    const dibaleslagi = document.createElement('div');
                    dibaleslagi.className = `dibales lagi-${data.comstoriesid} hidden`;
                    dibaleslagi.id = `lagi-${data.comstoriesid}`;
                    const inpbalassaja = document.createElement('input');
                    inpbalassaja.type = 'text';
                    inpbalassaja.className = `inpbalassaja inpbalassaja-${data.comstoriesid}`;
                    inpbalassaja.id = `inpbalassaja-${data.comstoriesid}`;
                    inpbalassaja.placeholder = 'Kirim balasan...';
                    inpbalassaja.required = true;
                    const inpbalassajahidden = document.createElement('input');
                    inpbalassajahidden.type = 'hidden';
                    inpbalassajahidden.value = data.comstoriesid;
                    inpbalassajahidden.id = `inpbalassajahidden-${data.comstoriesid}`;
                    const submitDibales = document.createElement('button');
                    submitDibales.type = 'submit';
                    submitDibales.className = `btnimg-sendcom btnimg-sendcom-${data.comstoriesid}`;
                    submitDibales.id = `btnimg-sendcom-${data.comstoriesid}`;
                    const dibalesIMG = document.createElement('img');
                    dibalesIMG.className = 'iclikescmt1';
                    dibalesIMG.src = `{{ asset('partses/sendcomdm.png') }}`;
                    const imgupload = document.createElement('img');
                    imgupload.src = `{{ asset('partses/import.png') }}`;
                    imgupload.className = 'iclikestoryimp1';
                    imgupload.id = `importbtn1-${data.comstoriesid}`;
                    const inpfile = document.createElement('input');
                    inpfile.type = 'file';
                    inpfile.accept = 'image/*';
                    inpfile.id = `filepicker1-${data.comstoriesid}`;
                    inpfile.className = 'hidden';
                    const brort = document.createElement('div');
                    brort.className = `brcmt2 hidden`;
                    brort.id = `divbrcmt2-${data.comstoriesid}`;
                    const brortp = document.createElement('p');
                    brortp.id = `brcmt2-${data.comstoriesid}`;
                    container.appendChild(commentwrapcom001);
                    commentwrapcom001.append(card, wrappercom2);
                    card.append(aharen, dispcard);
                    aharen.appendChild(img);
                    dispcard.append(ddispcanam, pComment);
                    ddispcanam.appendChild(aharen1);
                    aharen1.appendChild(pName);
                    wrappercom2.append(balaskan001, dibaleslagi);
                    balaskan001.append(suka, balaskan, urungkansaja, created);
                    dibaleslagi.append(brort, imgupload, inpfile, inpbalassaja, inpbalassajahidden, submitDibales);
                    brort.appendChild(brortp);
                    submitDibales.appendChild(dibalesIMG);
                    balaskan.addEventListener('click', () => {
                        dibaleslagi.classList.remove('hidden');
                        balaskan.classList.add('hidden');
                        urungkansaja.classList.remove('hidden');
                        inpbalassaja.focus();
                    });
                    urungkansaja.addEventListener('click', () => {
                        dibaleslagi.classList.add('hidden');
                        balaskan.classList.remove('hidden');
                        urungkansaja.classList.add('hidden');
                    });
                    function setupSendButtonListener(submitButton, inputElement, hiddenInputElement, fileInputElement, targetId) {
                        submitButton.addEventListener('click', function(event) {
                            event.preventDefault();
                            const previewImageContainer = document.querySelector(`#divbrcmt2-${targetId} .image-preview1`);
                            handleSendComment(submitButton, inputElement, hiddenInputElement, fileInputElement, previewImageContainer, targetId);
                        });
                        inputElement.addEventListener('keydown', (e) => {
                            if (e.key === 'Enter' && !e.shiftKey) {
                                e.preventDefault(); 
                                const previewImageContainer = document.querySelector(`#divbrcmt2-${targetId} .image-preview1`);
                                handleSendComment(submitButton, inputElement, hiddenInputElement, fileInputElement, previewImageContainer, targetId);
                            }
                        });
                    }
                    function handleSendComment(buttonElement, inputOL, commentses1, fileInput1, delprev1, targetid) {
                        if (buttonElement.disabled) return;
                        const message1 = inputOL.value.trim();
                        const storyCode1 = commentses1.value.trim();
                        const hasImage = fileInput1?.files.length > 0;
                        if (!hasImage && message1.length === 0) {
                            return;
                        }
                        buttonElement.disabled = true;
                        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
                        const formData = new FormData();
                        formData.append('storyCode1', storyCode1);
                        formData.append('message1', message1);
                        if (hasImage) {
                            formData.append('fileInput1', fileInput1.files[0]);
                        }
                        fetch('/enter-typing1', {
                            method: 'POST',
                            headers: { 'X-CSRF-TOKEN': csrfToken },
                            body: formData
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (!data.logged_in) {
                                window.location.href = data.redirect;
                                return;
                            }
                            inputOL.value = '';
                            if (fileInput1) fileInput1.value = '';
                            delprev1?.remove();
                            dibaleslagi.classList.add('hidden');
                            balaskan.classList.remove('hidden');
                            urungkansaja.classList.add('hidden');
                        })
                        .catch(error => console.error('Error:', error))
                        .finally(() => {
                            setTimeout(() => { buttonElement.disabled = false; }, 300);
                        });
                    }
                    function setupImageUpload(importButton, storyCode1, fileInputElement, inputElement) {
                        importButton.addEventListener('click', () => {
                            fileInputElement.click();
                        });

                        fileInputElement.addEventListener('change', function () {
                            const file = this.files[0];
                            if (file && file.type.startsWith('image/')) {
                                const reader = new FileReader();
                                reader.onload = function (event) {
                                    showImagePreview1(event.target.result, storyCode1, fileInputElement);
                                };
                                reader.readAsDataURL(file);
                            }
                        });
                        inputElement.addEventListener('paste', function (e) {
                            const items = (e.clipboardData || e.originalEvent.clipboardData).items;
                            for (let item of items) {
                                if (item.type.indexOf("image") === 0) {
                                    const file = item.getAsFile();
                                    const dataTransfer = new DataTransfer();
                                    dataTransfer.items.add(file);
                                    fileInputElement.files = dataTransfer.files;
                                    const reader = new FileReader();
                                    reader.onload = function (event) {
                                        showImagePreview1(event.target.result, storyCode1, fileInputElement);
                                    };
                                    reader.readAsDataURL(file);
                                }
                            }
                        });
                    }
                    function showImagePreview1(imageSrc, storyCode1, fileInputElement) {
                        const dibalesContainer = document.getElementById('lagi-' + storyCode1);
                        if (!dibalesContainer) return;

                        const oldPreview = dibalesContainer.querySelector('.image-preview1');
                        if (oldPreview) {
                            oldPreview.remove();
                        }
                        const preview = document.createElement('div');
                        preview.className = 'image-preview1 image-preview1-' + storyCode1;
                        preview.id = 'image-preview1-' + storyCode1;
                        preview.style.position = 'relative';
                        preview.style.display = 'inline-block';
                        const img = document.createElement('img');
                        img.src = imageSrc;
                        img.style.height = '60px';
                        img.style.borderRadius = '8px';
                        const delimg = document.createElement('button');
                        delimg.innerHTML = '&times;';
                        delimg.className = 'bcloimcom1';
                        delimg.onclick = () => {
                            preview.remove(); 
                            fileInputElement.value = '';
                        };
                        preview.appendChild(img);
                        preview.appendChild(delimg);
                        dibalesContainer.prepend(preview);
                    }
                    setupSendButtonListener(submitDibales, inpbalassaja, inpbalassajahidden, inpfile, data.comstoriesid);
                    setupImageUpload(imgupload, data.comstoriesid, inpfile, inpbalassaja); 
                  }
              }
          });
          window.channelBound1 = true;
      };
      document.querySelectorAll('[id^="divbrcmt-"]').forEach(getstorycode => {
        const getstorycd = getstorycode.id.replace('divbrcmt-', '');
        window.channel1.bind('broadcast.typing', function (data) {
            if (data.reqplat && data.reqplat.length > 0) {
              if (data.reqplat == getstorycd) {
                const cardmengetik = document.getElementById('divbrcmt-' + getstorycd);
                const teksmengetik = document.getElementById('brcmt-' + getstorycd);
                cardmengetik.classList.remove('hidden');
                teksmengetik.innerText = `${data.username} sedang mengetik...`;
                clearTimeout(window.typingTimeout);
                window.typingTimeout = setTimeout(() => {
                    teksmengetik.innerText = '';
                    cardmengetik.classList.add('hidden');
                }, 2000);
              }}
        });
      });
  </script><!-- pusher broadcasting dan chat awal comment -->
  
</html>