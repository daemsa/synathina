<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
//session in form to prevent double submits
$session = JFactory::getSession();
$user = JFactory::getUser();
$session->set( 'editform', md5($user->id.'-'.time()) );
$editform_session=$session->get( 'editform' );

//db connection
$db = JFactory::getDBO();
$config = JFactory::getConfig();

$user = JFactory::getUser();
$isroot = $user->authorise('core.admin');

//activities
$activities = $this->activities;
$activities_array_info=array();
foreach($activities as $activity){
	$activities_array_info[$activity->id]=array($activity->name, $activity->image);
}

$months=array(1=>'ΙΑΝ','ΦΕΒ','ΜΑΡ','ΑΠΡ','ΜΑΙ','ΙΟΥΝ','ΙΟΥΛ','ΑΥΓ','ΣΕΠ','ΟΚΤ','ΝΟΕ','ΔΕΚ');


$app = JFactory::getApplication();
$templateDir = JURI::base() . 'templates/' . $app->getTemplate();

//get lang variables
$lang = JFactory::getLanguage();
$this->language = $lang->getTag();//$doc->language;
$lang_code_array=explode('-',$this->language);
$lang_code=$lang_code_array[0];
$breadcumbs_modules=JModuleHelper::getModules('breadcumbs');

// IMPORT EDITOR CLASS
jimport( 'joomla.html.editor' );

// GET EDITOR SELECTED IN GLOBAL SETTINGS
$global_editor = $config->get( 'editor' );

// GET USER'S DEFAULT EDITOR
$user_editor = JFactory::getUser()->getParam("editor");

if($user_editor && $user_editor !== 'JEditor') {
    $selected_editor = $user_editor;
} else {
    $selected_editor = $global_editor;
}

// INSTANTIATE THE EDITOR
$editor = JEditor::getInstance($selected_editor);

// SET EDITOR PARAMS
$params_editor = array( 'smilies'=> '0' ,
    'style'  => '1' ,
    'layer'  => '0' ,
    'table'  => '0' ,
    'clear_entities'=>'0'
);

$user_team = $this->team;
$action = $this->action;
$subactions = $this->subactions;

if ($action->origin ==2) {
	header('Location: /');
	die;
}

?>
<script>
function openChild(file,window,id,lat,lng) {
	file=file+'?address_name='+id+'&lng_name='+lng+'&lat_name='+lat+'&lat='+document.getElementById(lat).value+'&lng='+document.getElementById(lng).value+'&address='+document.getElementById(id).value;
  var left = (screen.width/2)-(750/2);
  var top = (screen.height/2)-(550/2);
	childWindow=open(file,window,'resizable=no,width=750,height=550, top='+top+', left='+left);
	if (childWindow.opener == null) childWindow.opener = self;
}
function show_hide(f,show){
	var f1=parseInt(f)+1;
	var f2=parseInt(f)-1;
	if(show==1){
		$('#form-block-'+f1).fadeToggle("slow", "linear");
		$('#ypotitlos_drashs_'+f1).val($('#ypotitlos_drashs_'+f).val());
		$('#address_'+f1).val($('#address_'+f).val());
		$('#lat_'+f1).val($('#lat_'+f).val());
		$('#lng_'+f1).val($('#lng_'+f).val());
		$('.add_button').css('display','none');
		$('#add_'+f1).css('display','block');
		$('#remove_'+f1).attr('style','visibility:visible!important');
	}else{
		$('#ypotitlos_drashs_'+f).attr('value','');
		$('#form-block-'+f).hide("slow");
		$('#address_'+f).val();
		$('#lat_'+f).val();
		$('#lng_'+f).val();
		$('#add_'+f).css('display','block');
		if(f>1){
			$('#remove_'+f2).attr('style','visibility:visible!important');
		}
		$('#add_'+f2).css('display','block');
	}
}

function delete_confirmation(id,path,abspath) {
			var answer = confirm("Είστε σίγουροι πως θέλετε να διαγράψετέ αυτή την εικόνα;");
			if (answer){
				$.ajax({
					url: abspath+'delete_photo_action.php',
					type: 'post',
					data: {'path':path},
					success: function(data, status) {
						if(data == 1) {
							$('#photo_'+id).remove();
							alert('Η φωτογραφία διαγράφηκε επιτυχώς');
						}
					},
					error: function(xhr, desc, err) {
					}
				});
			}else{
				return false;
			}
}

</script>

<div class="l-register">
<?php
		foreach ($breadcumbs_modules as $breadcumbs_module){
			echo JModuleHelper::renderModule($breadcumbs_module);
		}
?>
   <div class="module module--synathina">
      <div class="module-skewed">
         <!-- Content Module -->
         <div class="register">
            <h3 class="popup-title">Επεξεργασία δράσης:</h3>
						<span>
							Για να καταχωρίσετε τη δράση σας είναι απαραίτητο να συμπληρώσετε τα στοιχεία τουλάχιστον μίας επιμέρους δράσης.
							<br />Σε περίπτωση που η πρωτοβουλία σας σας είναι επαναλαμβανόμενη ή περιλαμβάνει επιπλέον δράσεις σε διαφορετικό τόπο ή χρόνο, μπορείτε να πιέσετε το + για να προσθέσετε τα απαραίτητα στοιχεία.
							<br />Παρακαλούμε βεβαιωθείτε ότι έχετε καταχωρίσει όλα τα σημεία στο χάρτη καθώς και τις διαφορετικές ημέρες και ώρες.<br /><br />
						</span>
            <form action="<?php echo JURI::current();?>" class="form" method="post" name="create_action" id="edit_action" enctype="multipart/form-data">
<?php
if($isroot==1){
?>
							<div class="form-inline l-fg6 max-600">
								<div class="form-group">
									 <input id="best_practice" name="best_practice" type="checkbox" <?=($action->best_practice == 1 ? 'checked = "checked"' : '') ?> />
									 <label for="best_practice" class="is-block">Best practice</label>
								</div>
							</div>
							<div class="form-inline l-fg6 max-600">
								<div class="form-group">
									 <input id="published" name="published" type="checkbox" <?=($action->published==1?'checked="checked"':'')?> />
									 <label for="published" class="is-block">Published</label>
								</div>
							</div>
<?php
}else{
?>
						<input type="hidden" name="best_practice" value="<?php echo $action->best_practice; ?>" />
<?php
}
?>
							<div class="form-inline l-fg6 max-600">
								<div class="form-group">
									 <label for="name" class="is-block">Τίτλος δράσης*:</label>
									 <input id="name" name="name" type="text" value="<?php echo htmlspecialchars($action->name); ?>" required />
								</div>
								<div class="form-group form-group--upload">
									 <label for="image" class="is-block">Κεντρική φωτογραφία*:</label>
									 <input type="file" name="image" id="image" class="file-browser" />
									 <span class="is-block is-italic">(μέγιστο μέγεθος φωτογραφίας: 1 MB)</span>
									 <br />
<?php
	if ($action->image!='' && file_exists('images/actions/main_images/'.$action->image)) {
		echo '<img src="images/actions/main_images/'.$action->image.'" alt="" style="max-height:120px;" />';
	}
?>
								</div>
							</div>
							<div class="form-group form-inline is-block form--bordered" style="border-bottom: none; padding-bottom:0px; margin-bottom:0px;">
								<label for="short_description" class="is-block">Σύντομη Περιγραφή*:</label>
								<textarea style="max-height: 100px;" class="form-control max-600" maxlength="250" id="short_description" rows="8" name="short_description" required><?php echo stripslashes(str_replace("<br />","",$action->short_description)); ?></textarea>
								<span class="is-block is-italic">(σύντομη περιγραφή της δράσης σας έως 250 χαρακτήρες)</span>
							</div>
							<div class="form-group form-inline is-block ">
								<label for="activity_description" class="is-block">Περιγραφή*:</label>
								<!--<textarea class="form-control max-600" id="activity_description" rows="8" required=""></textarea>-->
								<?php echo $editor->display('activity_description', $action->description, '100%', '200', '', '20', true, null, null, null, $params_editor); ?>
								<span class="is-block is-italic">(το δελτίο τύπου της δράσης σας)</span>
							</div>
	            <div class="form-group form--bordered">
								<label class="is-block">Link δράσης:</label>
								<input type="text" name="web_link"  class="input--medium" id="web_link" value="<?php echo stripslashes($action->web_link); ?>" />
								<span class="is-block is-italic">(https://www.facebook.com/events/123456789/)</span>
							</div>
               <!-- clone start -->
<?php
	for($f=0; $f<11; $f++){
?>
              <div class="form-block" id="form-block-<?php echo $f; ?>" rel="js-form-block" style="display:<?=($f>=count($subactions)?'none':'block')?>">
								<h2>Επιμέρους Δράση <?php echo ($f+1); ?></h2>
								<div class="form-group form--padded--16">
									<label class="is-block">Υπότιτλος δράσης*:</label>
									<input type="text" name="ypotitlos_drashs_<?php echo $f; ?>"  value="<?php echo htmlspecialchars(@$subactions[$f]->subtitle); ?>" class="input--medium" id="ypotitlos_drashs_<?php echo $f; ?>" <?=($f==0?'required=""':'')?>  />
								</div>
	              <div class="form form--padded--16">
	               	<label class="is-block">Τοποθεσία:</label>
	               	<div class="form-inline--cells form-inline v-bottom">
				            <div class="form-group" id="address_fields_<?php echo $f; ?>" <?=(@$subactions[$f]->stegi_use==1?'style="display:none;"':'')?>>
											<label class="is-block">ΔΙΕΥΘΥΝΣΗ:</label>
											<input value="<?php echo stripslashes(@$subactions[$f]->address); ?>" type="text" name="address_<?php echo $f; ?>" id="address_<?php echo $f; ?>" onclick="openChild('<?php echo JURI::base(); ?>gmap_action2.php','win<?php echo $f; ?>',this.id,'lat_<?php echo $f; ?>','lng_<?php echo $f; ?>')" style="width:80%" />
											<input value="<?php echo stripslashes(@$subactions[$f]->lat); ?>" type="hidden" name="lat_<?php echo $f; ?>" id="lat_<?php echo $f; ?>" />
											<input value="<?php echo stripslashes(@$subactions[$f]->lng); ?>" type="hidden" name="lng_<?php echo $f; ?>" id="lng_<?php echo $f; ?>" />
										</div>
										<div class="form-group stegi_use" >
											<input <?=(@$subactions[$f]->stegi_use==1?'checked="checked"':'')?> id="stegi_<?php echo $f; ?>" name="stegi_<?php echo $f; ?>" type="checkbox" data-href="<?php echo $f; ?>">
											<label for="stegi_<?php echo $f; ?>" class="label-horizontal"><small>ΧΡΗΣΗ ΣΤΕΓΗΣ ΣΥΝΑΘΗΝΑ</small></label>
										</div>
									</div>
	              </div>
<?php
	$action_date_start_new='';
	$action_date_end_new='';
	if(@$subactions[$f]->action_date_start!=''){
		$startDate = $subactions[$f]->action_date_start.'.000000';
		$action_date_start = new DateTime($startDate);
		$action_date_start_new=$action_date_start->format('d/m/Y H:i');
	}
	if(@$subactions[$f]->action_date_end!=''){
		$endDate = $subactions[$f]->action_date_end.'.000000';
		$action_date_end = new DateTime($endDate);
		$action_date_end_new=$action_date_end->format('d/m/Y H:i');
	}
?>
	              <div class="form form--padded--16">
	               	<label class="is-block">ΗΜΕΡΟΜΗΝΙΑ*:</label>
	               	<div class="form-inline--cells form-inline v-bottom">
		               	<div class="form-group">
		               		<label for="from_date_<?php echo $f; ?>" class="is-block">Από</label>
		               		<input value="<?php echo $action_date_start_new; ?>" type="text" class="from_date_edit" id="from_date_<?php echo $f; ?>" name="date_start_<?php echo $f; ?>" <?=($f==0?'required=""':'')?>  />
							<label for="to_date_<?php echo $f; ?>" class="is-block">Έως</label>
		               		<input value="<?php echo $action_date_end_new; ?>" type="text" class="to_date_edit" id="to_date_<?php echo $f; ?>" name="date_end_<?php echo $f; ?>" <?=($f==0?'required=""':'')?>  />
		               	</div>
	               	</div>
	               </div>
								<div class="form-inline filters form--padded form--bordered">
									<label for="activity_description" class="is-block">Θεματικές δραστηριοποίησης*:</label>
<?php
	$sub_activities=array();
	$sub_activities=explode(',',@$subactions[$f]->activities);
	array_filter($sub_activities);
	foreach($this->activities AS $activity){
		echo '<div class="form-group">
						 <input id="activity_'.$activity->id.'_'.$f.'" name="activity_'.$activity->id.'_'.$f.'" type="checkbox" '.(in_array($activity->id,$sub_activities)?'checked="checked"':'').'>
						 <label for="activity_'.$activity->id.'_'.$f.'" class="label-horizontal">'.$activity->name.'</label>
					</div>';
	}
?>
								</div>
								<button type="button" class="add_button btn btn--black btn--add clone" <?=(($f+1)==count($subactions)?'style="display:block"':'style="display:none"')?> rel="js-add-new-form-block" id="add_<?php echo $f; ?>" onclick="show_hide(<?php echo $f; ?>,1)"></button>
                <button type="button" class="remove_button btn btn--black btn--minus remove <?=(($f+1)==count($subactions)&&$f>0?'':'')?>" rel="js-remove-new-form-block"  onclick="show_hide(<?php echo $f; ?>,0)" id="remove_<?php echo $f; ?>"></button>
							</div>
<?php
	}
?>
					<!-- clone end -->
							<div class="form form--bordered">
								<div class="form-group">
									<label for="date" class="is-block">Συνεργαζόμενες ομάδες</label>
									<div class="form-group form-inline v-center">
										<select id="tokenize" multiple="multiple" name="teams[]" class="tokenize-sample">
<?php
	$partners=array();
	$partners=explode(',',$action->partners);
	array_filter($partners);
	foreach($this->teams AS $team){
		echo '<option '.(in_array($team->id,$partners)?'selected="selected"':'').' value="'.$team->id.'" rel="'.JURI::base().($team->logo!=''?$team->logo:'images/template/no-team.jpg').'" id="team_logo_'.$team->id.'">'.$team->name.'</option>';
	}
?>

										</select>
										<span id="logos_select">
<?php
	foreach($this->teams AS $team){
		if(in_array($team->id,$partners)){
			echo '<img id="team_logo_img_'.$team->id.'" src="'.$team->logo.'" width="32" height="32" style="margin-right:5px;" title="'.str_replace('"','\'',$team->name).'" alt="">';
		}
	}
?>
										</span>
									</div>
								</div>
								<div class="form-group">
									<label for="date" class="is-block">Υποστηρικτές</label>
									<div class="form-group form-inline v-center">
										<select id="tokenize1" multiple="multiple" name="supporters[]" class="tokenize-sample">
<?php
	$supporters=array();
	$supporters=explode(',',$action->supporters);
	array_filter($supporters);

	foreach($this->supporters AS $team){
		echo '<option '.(in_array($team->id,$supporters)?'selected="selected"':'').' value="'.$team->id.'" rel="'.JURI::base().($team->logo!=''?$team->logo:'images/template/no-team.jpg').'" id="team_logo_'.$team->id.'">'.$team->name.'</option>';
	}
?>

										</select>
										<span id="logos_select1">
<?php
	foreach($this->supporters AS $team){
		if(in_array($team->id,$supporters)){
			echo '<img id="team_logo_img1_'.$team->id.'" src="'.$team->logo.'" width="32" height="32" style="margin-right:5px;" title="'.str_replace('"','\'',$team->name).'" alt="">';
		}
	}
?>
										</span>
									</div>
								</div>
								<div class="margin0 form-group form-group--upload">
									 <label for="box70" class="is-block">Φωτογραφίες:</label>
						 <div style="vertical-align:top; margin-bottom:10px;" class="clearfix">
<?php
	$p=0;
	foreach (glob('images/actions/'.$action->id.'/*.*') as $photo) {
			echo '<div id="photo_'.$p.'" style="display:block; position:relative; float:left; vertical-align:top;width:80px; height:80px; margin-right:2px;">
							<img style="position:absolute; top:0px; left:0px; width:80px; height:80px; vertical-align:top" src="'.$photo.'" alt=""/>
							<a onclick="delete_confirmation(\''.$p.'\',\''.$photo.'\',\''.JUri::base().'\')" href="javascript:void(null)" style="position:absolute; right:5px; top 5px;color:red">x</a>
						</div>';
		$p++;
	}

?>
					</div>
									 <input type="file" name="photos[]" id="box70" class="file-browser" multiple>
									 <span class="is-block is-italic"><small>( μπορείτε να ανεβάσετε την  αφίσα της  δράσης σας, φωτογραφίες
						της τρέχουσας δράσης σας ή και φωτογραφίες από προηγούμενες δράσεις - μέγιστο επιτρεπόμενο όριο φωτογραφίας: 1MB )</small></span>
								</div>
								<div class="form-group" id="services_choice">
									<input id="services" type="checkbox" name="services" <?=($action->municipality_services!=''?'checked="checked"':'')?>>
									<label for="services" class="label-horizontal"><small>ΧΡΗΣΗ ΥΠΗΡΕΣΙΩΝ ΔΗΜΟΥ ΑΘΗΝΑΙΩΝ</small></label>
								</div>
								<div class="form-inline filters form--padded" id="service_list" <?=($action->municipality_services!=''?'':'style="display:none"')?>>
									<div style="display:block" class="form-inline">
										<label class="is-block">Θα επιθυμούσα:</label>
<?php
	$municipality_services=array();
	$municipality_services=explode(',',$action->municipality_services);
	array_filter($municipality_services);
	foreach($this->services AS $service){
?>
										<div class="form-group">
											 <input id="<?php echo $service->id; ?>" type="checkbox" name="service_<?php echo $service->id; ?>" <?=(in_array($service->id,$municipality_services)?'checked="checked"':'')?>>
											 <label  style="" for="<?php echo $service->id; ?>" class="label-horizontal"><?php echo $service->name; ?></label>
										</div>
<?php
	}
?>
									</div>
									<div class="form-group is-block form" style="padding-top:12px">
										<label class="is-block">Μήνυμα προς τις υπηρεσίες του δήμου*:</label>
										<textarea name="services_message" class="form-control max-600" id="services_message" rows="8"><?php echo stripslashes(str_replace("<br />","",$action->municipality_message)); ?></textarea>
                                        <span class="is-block is-italic">(Επεξηγήστε με σαφήνεια τη μορφή υποστήριξης που θέλετε να λάβετε. Το μήνυμά σας θα προωθηθεί στις αρμόδιες δημοτικές υπηρεσίες)</span>
									</div>
								</div>
							</div>
							<div class="form-inline form--bordered filters " rel="">
								<label for="activity_description" class="is-block">Θα επιθυμούσα την υποστήριξη σε:</label>
<?php
	$donations=array();
	if(trim($action->org_donation)!=''){
		$donations=explode(',',$action->org_donation);
		array_filter($donations);
	}

		$rows=$this->team_donation_types;
		$i=1;
		$children=array();
		foreach($rows as $row){
			$query = " SELECT id, name "
					." FROM #__team_donation_types
						WHERE published=1 AND parent_id=".$row->id."	"
					." ORDER BY id ASC ";

			$db->setQuery($query);
			$rows1=$db->loadObjectList();

			$messageDivArray[$row->id] = ['name'=>$row->name, 'children' =>[]];
			foreach($rows1 as $row1){
				$children[$i][]=array($row1->id, $row1->name,$row->id);
				array_push($messageDivArray[$row->id]['children'], [$row1->name, $row1->id]);
			}
			echo '<div class="form-group support_fields">
							 <input name="donation-'.$row->id.'" id="donation-'.$row->id.'" type="checkbox" value="show"  '.(@count($children[$i])>0?'data-href="#subcat'.$i.'"':'').' '.(in_array($row->id,$donations)?'checked="checked"':'').'>
							 <label for="donation-'.$row->id.'" class="label-horizontal">'.$row->name.'</label>
						</div>';
			$i++;
		}

		for($i=1; $i<count($children)+1; $i++){
			for($y=0; $y<count($children[$i]); $y++){
				if($y==0){
					echo '<div id="subcat'.$i.'" rel="js-show-category-types" style="'.(in_array($children[$i][$y][2],$donations)?'':'display:none;').'padding-bottom:12px; border-bottom:1px solid #CCC" class="form-block form-inline donation-'.$children[$i][$y][2].'">';
				}
				echo '<div class="form-group">
								<input name="donation-'.$children[$i][$y][2].'-'.$children[$i][$y][0].'" id="donation-'.$children[$i][$y][2].'-'.$children[$i][$y][0].'"  type="checkbox" '.(in_array($children[$i][$y][0],$donations)?'checked="checked"':'').'>
								<label for="donation-'.$children[$i][$y][2].'-'.$children[$i][$y][0].'" class="label-horizontal">'.$children[$i][$y][1].'</label>
							</div>';
				if($y==(count($children[$i])-1)){
						$other_donation='';
						if($children[$i][$y][2]==1){
							$other_donation=$action->donation_eidos;
						}
						if($children[$i][$y][2]==16){
							$other_donation=$action->donation_technology;
						}
						echo '<div class="form-group">
										<label for="donation-'.$children[$i][$y][2].'-other" class="label-horizontal" style="display:inline-block">'.($lang_code=='en'?'Other':'Άλλο').'</label>
										<input name="donation-'.$children[$i][$y][2].'-other" id="donation-'.$children[$i][$y][2].'-other"  type="text" value="'.str_replace('"','\'',$other_donation).'">
									</div>';
					echo '</div>';
				}
			}

		}
?>
							</div>

              <?php
			if (@unserialize($action->supporters_message)) {
				$messagesToSupporters = unserialize($action->supporters_message);
			} else {
				$messagesToSupporters = unserialize(base64_decode($action->supporters_message));
			}
            foreach($messageDivArray as $parentKey => $subArray) {
                if(count($subArray['children'])){
                  foreach($subArray['children'] as $child) { ?>
                      <div class="form-group form--padded donation-message child-donation-message textarea-donation-<?php echo $parentKey."-".$child[1] ?>" <?php if(@$messagesToSupporters[$child[1]] == '') { echo 'style="display:none"'; } ?>>
                          <label for="support_message" class="is-block">Μήνυμα προς <?php echo $child[0] ?>*:</label>
                          <textarea class="form-control max-600" id="support_message-<?php echo $parentKey."-".$child[1] ?>" rows="8" name="support_message-<?php echo $parentKey."-".$child[1] ?>" <?php if(@$messagesToSupporters[$child[1]] != ''){ echo 'required="required"'; } ?>><?php echo @$messagesToSupporters[$child[1]]; ?></textarea>
                      </div>
                  <?php }
                } else { ?>
                    <div class="form-group form--padded donation-message parent-donation-message textarea-donation-<?php echo $parentKey ?>"  <?php if(@$messagesToSupporters[$parentKey] == '') { echo 'style="display:none"'; } ?>>
                        <label for="support_message" class="is-block">Μήνυμα προς <?php echo $subArray['name']; ?>*:</label>
                        <textarea class="form-control max-600" class="support_message" id="support_message-<?php echo $parentKey ?>" rows="8" name="support_message-<?php echo $parentKey ?>" <?php if(@$messagesToSupporters[$parentKey] != ''){ echo 'required="required"'; } ?>><?php echo @$messagesToSupporters[$parentKey]; ?></textarea>
                    </div>
                <?php }
              }
              ?>
            <?php if ($isroot) { ?>
            	<div class="clearfix"></div>
				<div class="form-group form--padded">
					<input id="remote" type="checkbox" name="remote" <?=($action->remote == 1 ? 'checked="checked"' : '')?> />
					<label for="remote" class="label-horizontal"><small>*Δέχομαι να καταχωρηθεί η δράση μου στο accmr.gr</small></label>
				</div>
			<?php } ?>
               	<div class="form-group form-group--tail is-block clearfix">
                	<span class="pull-left"><em>*Υποχρεωτικά πεδία</em></span>
                  	<button type="submit" class="pull-right btn btn--coral btn--bold">Καταχώριση</button>
               	</div>
				<input type="hidden" name="option" value="com_actions" />
				<input type="hidden" name="task" value="edit.save" />
				<input type="hidden" name="team_id" value="<?php echo $user_team->id; ?>" />
				<input type="hidden" name="action_id" value="<?php echo $action->id; ?>" />
				<input type="hidden" name="user_id" value="<?php echo $user_team->user_id; ?>" />
				<input type="hidden" name="editform" value="<?php echo $editform_session; ?>" />
				<input type="hidden" name="return" value="<?php echo JRoute::_('index.php?option=com_actions&view=myactions&Itemid=143');?>" />
				<input type="hidden" name="return_false" value="<?php echo JRoute::_('index.php?option=com_actions&view=myactions&Itemid=143&action_error=1');?>" />
				<?php echo JHtml::_('form.token');?>
            </form>
        </div>
      </div>
    </div>
</div>
