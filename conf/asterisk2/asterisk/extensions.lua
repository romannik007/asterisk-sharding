
function do_hangup()
  app.hangup()
end;

function do_dial(context, exten)
  app.dial(exten,nil,"m")
end;

function recording(callerid, exten)
  app.noop("Recording exten: " .. exten)
  channel["CDR(realdst)"]:set(exten)
  local ip = channel["CHANNEL(peerip)"]:get()
  if ip ~= nil then
    channel["CDR(remoteip)"]:set(ip)
    app.noop("recvip: " .. ip)
  else
    channel["CDR(remoteip)"]:set("")
    app.noop("recvip: " .. "nil")
  end
  
end;

function ivr(context, exten)
  app.noop("Включено голосовое меню")
  app.noop("Extention: "..exten)
  app.read("IVR_CHOOSE","beep",2, nil, 1, 5)
  local choose = channel.IVR_CHOOSE:get()
  app.noop("choose: " .. choose)
  if choose == "11" then
    app.noop("choose: " .. 11)
    --recording(nil,"1011")
    do_dial(context, "SIP/1011")
    local dialstatus = channel["DIALSTATUS"]:get()
-- если занято - добавить в диалплан
  elseif choose == "12" then
    app.noop("choose: " .. 12)
    --recording(nil,"1012")
    do_dial(context, "SIP/1012")
  else
    app.noop("choose: " .. "else")
    recording(nil,"1002")
    app.dial("SIP/1002",10,"m")
    if channel["DIALSTATUS"]:get() == "NOANSWER" then
      app.noop("DIALSTATUS NOANSWER")
      recording(nil, "1008")
      app.dial("SIP/1008",nil,"m")
    end
  end;
end;

extensions = {
    From_TA410 = {
      ["9999"] = function(c, exten)
        app.noop("Ответ 9999")
        app.noop("From_TA410 : " .. exten)
        app.answer()
        ivr(c,exten)
        do_hangup()
      end;
    };

    --extensions = {
      kamailio = {
          ["_ZXXX"] = function(context, exten)
            app.noop("Ответ kamailio")
            app.noop("kamailio : " .. exten)
            --recording(nil, exten)
            do_dial(context, "SIP/" .. exten)
          end;
      };

      internal = {
          ["_ZXXX"] = function(context, exten)
            app.noop("internal : " .. exten)
            --recording(nil, exten)
            do_dial(context, "SIP/" .. exten)
          end;
      };  

      To_TA410_local = {
          ["_9ZXXXX"] = function(context, exten)
            app.noop("TO_TA410_local : " .. exten)
            --recording(nil, exten)      
            do_dial(context, "SIP/TA410/" .. exten:sub(2))
            app.congestion()
            do_hangup()
          end;
      };


      TO_TA410_long = {
          ["_98ZXXXXXXXXX"] = function(context, exten)
            app.noop("TO_TA410_long : " .. exten)
            --recording(nil, exten:sub(2))      
            do_dial(context, "SIP/TA410/" .. exten:sub(2))
            app.congestion()
            do_hangup()
          end;
      };

      no_number = {
          ["_X."] = function(context, exten)
            app.Playback("pbx-invalid")
            do_hangup()
          end;
      };



      phones = {
          include = {"internal", "To_TA410_local","TO_TA410_long", "no_number", "kamailio"};
      };

    --};
};
-- extesion.from_TA410_first