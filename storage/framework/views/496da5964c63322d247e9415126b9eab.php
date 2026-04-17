

<?php $__env->startSection('page-title', 'Clinic Settings'); ?>

<?php $__env->startSection('content'); ?>

<div style="max-width: 900px; margin: 0 auto;">
  
  <div style="margin-bottom: 30px;">
    <h1 style="font-size: 1.875rem; font-weight: 700; color: #2f3e46; margin: 0; margin-bottom: 8px;">Clinic Settings</h1>
    <p style="color: #a8ada9; font-size: 0.95rem;">Manage your clinic information and configuration</p>
  </div>

  
  <?php if(session('success')): ?>
    <div style="background: #d1fae5; border: 1px solid #6ee7b7; border-radius: 8px; padding: 16px; margin-bottom: 24px; color: #065f46;">
      <strong>✓ Success!</strong> <?php echo e(session('success')); ?>

    </div>
  <?php endif; ?>

  
  <?php if($errors->any()): ?>
    <div style="background: #fee2e2; border: 1px solid #fca5a5; border-radius: 8px; padding: 16px; margin-bottom: 24px; color: #7f1d1d;">
      <strong>⚠ Error!</strong> Please fix the errors below:
      <ul style="margin: 8px 0 0 0; padding-left: 20px;">
        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <li><?php echo e($error); ?></li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </ul>
    </div>
  <?php endif; ?>

  
  <form action="<?php echo e(route('admin.clinic-settings.update')); ?>" method="POST" style="background: rgba(202, 210, 197, 0.15); backdrop-filter: blur(10px); border: 1px solid rgba(202, 210, 197, 0.3); padding: 32px; border-radius: 16px;">
    <?php echo csrf_field(); ?>

    
    <div style="margin-bottom: 32px;">
      <h3 style="font-size: 1.125rem; font-weight: 600; color: #52796f; margin: 0 0 20px 0;">Basic Information</h3>
      
      <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; margin-bottom: 20px;">
        <div>
          <label style="display: block; font-weight: 600; color: #2f3e46; margin-bottom: 8px; font-size: 0.95rem;">Clinic Name *</label>
          <input type="text" name="clinic_name" value="<?php echo e(old('clinic_name', $settings->clinic_name ?? '')); ?>" required pattern="[a-zA-Z0-9\s,.\-]+" title="Only letters, numbers, and basic punctuation allowed"
                 style="width: 100%; padding: 12px; border: 1px solid rgba(202, 210, 197, 0.5); background: rgba(255, 255, 255, 0.7); border-radius: 8px; font-size: 0.95rem; color: #2f3e46;">
          <?php $__errorArgs = ['clinic_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span style="color: #dc2626; font-size: 0.875rem;"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <div>
          <label style="display: block; font-weight: 600; color: #2f3e46; margin-bottom: 8px; font-size: 0.95rem;">Email *</label>
          <input type="email" name="email" value="<?php echo e(old('email', $settings->email ?? '')); ?>" required
                 style="width: 100%; padding: 12px; border: 1px solid rgba(202, 210, 197, 0.5); background: rgba(255, 255, 255, 0.7); border-radius: 8px; font-size: 0.95rem; color: #2f3e46;">
          <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span style="color: #dc2626; font-size: 0.875rem;"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
      </div>

      <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; margin-bottom: 20px;">
        <div>
          <label style="display: block; font-weight: 600; color: #2f3e46; margin-bottom: 8px; font-size: 0.95rem;">Phone *</label>
          <input type="tel" name="phone" value="<?php echo e(old('phone', $settings->phone ?? '')); ?>" required pattern="^(09[0-9]{9}|\\+639[0-9]{9})$" title="Enter valid Philippine phone number (09XXXXXXXXX or +639XXXXXXXXX)" maxlength="13"
                 style="width: 100%; padding: 12px; border: 1px solid rgba(202, 210, 197, 0.5); background: rgba(255, 255, 255, 0.7); border-radius: 8px; font-size: 0.95rem; color: #2f3e46;">
          <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span style="color: #dc2626; font-size: 0.875rem;"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <div>
          <label style="display: block; font-weight: 600; color: #2f3e46; margin-bottom: 8px; font-size: 0.95rem;">Emergency Phone</label>
          <input type="tel" name="emergency_phone" value="<?php echo e(old('emergency_phone', $settings->emergency_phone ?? '')); ?>" pattern="^(09[0-9]{9}|\\+639[0-9]{9})$" title="Enter valid Philippine phone number (09XXXXXXXXX or +639XXXXXXXXX)" maxlength="13"
                 style="width: 100%; padding: 12px; border: 1px solid rgba(202, 210, 197, 0.5); background: rgba(255, 255, 255, 0.7); border-radius: 8px; font-size: 0.95rem; color: #2f3e46;">
          <?php $__errorArgs = ['emergency_phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span style="color: #dc2626; font-size: 0.875rem;"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
      </div>

      <div>
        <label style="display: block; font-weight: 600; color: #2f3e46; margin-bottom: 8px; font-size: 0.95rem;">Address *</label>
        <input type="text" name="address" value="<?php echo e(old('address', $settings->address ?? '')); ?>" required pattern="[a-zA-Z0-9\s,.\-]+" title="Only letters, numbers, and basic punctuation allowed"
               style="width: 100%; padding: 12px; border: 1px solid rgba(202, 210, 197, 0.5); background: rgba(255, 255, 255, 0.7); border-radius: 8px; font-size: 0.95rem; color: #2f3e46;">
        <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span style="color: #dc2626; font-size: 0.875rem;"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
      </div>
    </div>

    
    <div style="margin-bottom: 32px; padding-bottom: 32px; border-bottom: 1px solid rgba(202, 210, 197, 0.3);">
      <h3 style="font-size: 1.125rem; font-weight: 600; color: #52796f; margin: 0 0 20px 0;">Location</h3>
      
      <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px;">
        <div>
          <label style="display: block; font-weight: 600; color: #2f3e46; margin-bottom: 8px; font-size: 0.95rem;">City *</label>
          <input type="text" name="city" value="<?php echo e(old('city', $settings->city ?? '')); ?>" required pattern="[a-zA-Z\s]+" title="Only letters and spaces allowed"
                 style="width: 100%; padding: 12px; border: 1px solid rgba(202, 210, 197, 0.5); background: rgba(255, 255, 255, 0.7); border-radius: 8px; font-size: 0.95rem; color: #2f3e46;">
          <?php $__errorArgs = ['city'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span style="color: #dc2626; font-size: 0.875rem;"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <div>
          <label style="display: block; font-weight: 600; color: #2f3e46; margin-bottom: 8px; font-size: 0.95rem;">Province *</label>
          <input type="text" name="province" value="<?php echo e(old('province', $settings->province ?? '')); ?>" required pattern="[a-zA-Z\s]+" title="Only letters and spaces allowed"
                 style="width: 100%; padding: 12px; border: 1px solid rgba(202, 210, 197, 0.5); background: rgba(255, 255, 255, 0.7); border-radius: 8px; font-size: 0.95rem; color: #2f3e46;">
          <?php $__errorArgs = ['province'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span style="color: #dc2626; font-size: 0.875rem;"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <div>
          <label style="display: block; font-weight: 600; color: #2f3e46; margin-bottom: 8px; font-size: 0.95rem;">Postal Code *</label>
          <input type="text" name="postal_code" value="<?php echo e(old('postal_code', $settings->postal_code ?? '')); ?>" required pattern="[0-9]+" title="Only numbers allowed" maxlength="10"
                 style="width: 100%; padding: 12px; border: 1px solid rgba(202, 210, 197, 0.5); background: rgba(255, 255, 255, 0.7); border-radius: 8px; font-size: 0.95rem; color: #2f3e46;">
          <?php $__errorArgs = ['postal_code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span style="color: #dc2626; font-size: 0.875rem;"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
      </div>
    </div>

    
    <div style="margin-bottom: 32px; padding-bottom: 32px; border-bottom: 1px solid rgba(202, 210, 197, 0.3);">
      <h3 style="font-size: 1.125rem; font-weight: 600; color: #52796f; margin: 0 0 20px 0;">System Settings</h3>
      
      <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px;">
        <div>
          <label style="display: block; font-weight: 600; color: #2f3e46; margin-bottom: 8px; font-size: 0.95rem;">Timezone *</label>
          <select name="timezone" required
                  style="width: 100%; padding: 12px; border: 1px solid rgba(202, 210, 197, 0.5); background: rgba(255, 255, 255, 0.7); border-radius: 8px; font-size: 0.95rem; color: #2f3e46;">
            <option value="Asia/Manila" <?php echo e(old('timezone', $settings->timezone ?? 'Asia/Manila') === 'Asia/Manila' ? 'selected' : ''); ?>>Asia/Manila (UTC+8)</option>
            <option value="Asia/Bangkok" <?php echo e(old('timezone', $settings->timezone ?? 'Asia/Manila') === 'Asia/Bangkok' ? 'selected' : ''); ?>>Asia/Bangkok (UTC+7)</option>
            <option value="UTC" <?php echo e(old('timezone', $settings->timezone ?? 'Asia/Manila') === 'UTC' ? 'selected' : ''); ?>>UTC</option>
          </select>
          <?php $__errorArgs = ['timezone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span style="color: #dc2626; font-size: 0.875rem;"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <div>
          <label style="display: block; font-weight: 600; color: #2f3e46; margin-bottom: 8px; font-size: 0.95rem;">Website</label>
          <input type="url" name="website" value="<?php echo e(old('website', $settings->website ?? '')); ?>" placeholder="https://..."
                 style="width: 100%; padding: 12px; border: 1px solid rgba(202, 210, 197, 0.5); background: rgba(255, 255, 255, 0.7); border-radius: 8px; font-size: 0.95rem; color: #2f3e46;">
          <?php $__errorArgs = ['website'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span style="color: #dc2626; font-size: 0.875rem;"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
      </div>

      <div style="margin-top: 20px;">
        <label style="display: block; font-weight: 600; color: #2f3e46; margin-bottom: 8px; font-size: 0.95rem;">Facebook URL</label>
        <input type="url" name="facebook_url" value="<?php echo e(old('facebook_url', $settings->facebook_url ?? '')); ?>" placeholder="https://facebook.com/..."
               style="width: 100%; padding: 12px; border: 1px solid rgba(202, 210, 197, 0.5); background: rgba(255, 255, 255, 0.7); border-radius: 8px; font-size: 0.95rem; color: #2f3e46;">
        <?php $__errorArgs = ['facebook_url'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span style="color: #dc2626; font-size: 0.875rem;"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
      </div>
    </div>

    
    <div style="margin-bottom: 32px; padding-bottom: 32px; border-bottom: 1px solid rgba(202, 210, 197, 0.3);">
      <h3 style="font-size: 1.125rem; font-weight: 600; color: #52796f; margin: 0 0 20px 0;">Fees</h3>
      
      <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px;">
        <div>
          <label style="display: block; font-weight: 600; color: #2f3e46; margin-bottom: 8px; font-size: 0.95rem;">Consultation Fee (₱)</label>
          <input type="number" name="consultation_fee" value="<?php echo e(old('consultation_fee', $settings->consultation_fee ?? 0)); ?>" step="0.01" min="0"
                 style="width: 100%; padding: 12px; border: 1px solid rgba(202, 210, 197, 0.5); background: rgba(255, 255, 255, 0.7); border-radius: 8px; font-size: 0.95rem; color: #2f3e46;">
          <?php $__errorArgs = ['consultation_fee'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span style="color: #dc2626; font-size: 0.875rem;"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <div>
          <label style="display: block; font-weight: 600; color: #2f3e46; margin-bottom: 8px; font-size: 0.95rem;">Vaccine Service Fee (₱)</label>
          <input type="number" name="vaccine_service_fee" value="<?php echo e(old('vaccine_service_fee', $settings->vaccine_service_fee ?? 0)); ?>" step="0.01" min="0"
                 style="width: 100%; padding: 12px; border: 1px solid rgba(202, 210, 197, 0.5); background: rgba(255, 255, 255, 0.7); border-radius: 8px; font-size: 0.95rem; color: #2f3e46;">
          <?php $__errorArgs = ['vaccine_service_fee'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span style="color: #dc2626; font-size: 0.875rem;"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
      </div>
    </div>

    
    <div style="margin-bottom: 32px;">
      <label style="display: block; font-weight: 600; color: #2f3e46; margin-bottom: 8px; font-size: 0.95rem;">Description</label>
      <textarea name="description" rows="4" placeholder="Brief description of your clinic..."
                style="width: 100%; padding: 12px; border: 1px solid rgba(202, 210, 197, 0.5); background: rgba(255, 255, 255, 0.7); border-radius: 8px; font-size: 0.95rem; color: #2f3e46; font-family: inherit;"><?php echo e(old('description', $settings->description ?? '')); ?></textarea>
      <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span style="color: #dc2626; font-size: 0.875rem;"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

    
    <div style="display: flex; gap: 12px;">
      <button type="submit" style="background: #52796f; color: white; padding: 12px 24px; border: none; border-radius: 8px; font-weight: 600; font-size: 0.95rem; cursor: pointer;">
        ✓ Save Settings
      </button>
      <a href="<?php echo e(route('admin.dashboard')); ?>" style="background: transparent; color: #52796f; padding: 12px 24px; border: 1px solid #52796f; border-radius: 8px; font-weight: 600; font-size: 0.95rem; text-decoration: none; display: inline-block;">
        Cancel
      </a>
    </div>
  </form>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\vacctrack\resources\views/admin/clinic-settings/edit.blade.php ENDPATH**/ ?>