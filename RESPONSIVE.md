# 📱 Responsive Design Guide - EtherSay

## Device Breakpoints

EtherSay menggunakan Tailwind CSS breakpoints:
- **Mobile**: < 768px (sm)
- **Tablet**: 768px - 1024px (md)
- **Desktop**: > 1024px (lg)

## Responsive Features

### 📱 Mobile (< 768px)

#### Sidebar
- **Hidden by default** - tidak memakan space
- **Hamburger menu** di kiri atas untuk buka sidebar
- **Full overlay** saat sidebar terbuka
- **Swipe/tap overlay** untuk tutup
- Auto-close saat pilih user untuk chat

#### Chat Area
- **Full width** - memaksimalkan ruang chat
- **Compact header** dengan text lebih kecil
- **Username truncated** jika terlalu panjang
- **Message bubbles** max-width 85% screen
- **Smaller padding** untuk message & input
- **Touch-friendly buttons** (bigger tap target)

#### Input Area
- **Smaller icons** (5x5 → 6x6)
- **Compact padding** untuk hemat ruang
- **File name truncated** jika terlalu panjang
- **Bigger send button** untuk mudah di-tap

### 📱 Tablet (768px - 1024px)

#### Sidebar
- **Visible** - sidebar selalu terlihat
- **Width 256px** (w-64) - lebih compact dari desktop
- **No overlay** - bukan modal

#### Chat Area
- **Standard sizing** dengan padding medium
- **Message bubbles** max-width sm
- **Balanced layout** antara sidebar & chat

### 🖥️ Desktop (> 1024px)

#### Sidebar
- **Width 320px** (w-80) - full width
- **All features visible** tanpa truncation

#### Chat Area
- **Full padding** untuk comfortable reading
- **Message bubbles** max-width md
- **Larger text** & icons

## Responsive Components

### 1. Chat Header
```blade
<!-- Mobile: Compact with hamburger -->
<div class="px-4 py-3 md:px-6 md:py-4">
    <!-- Hamburger hanya mobile -->
    <button class="md:hidden">...</button>
    
    <!-- Title -->
    <h2 class="text-lg md:text-xl">...</h2>
    
    <!-- Username truncated di mobile -->
    <div class="truncate max-w-[100px] md:max-w-none">
</div>
```

### 2. Message Bubbles
```blade
<!-- Responsive width -->
<div class="max-w-[85%] sm:max-w-sm md:max-w-md">
    <!-- Responsive padding -->
    <div class="p-2.5 md:p-3">
        <!-- Responsive text -->
        <p class="text-sm md:text-base">...</p>
    </div>
</div>
```

### 3. Online Users List
```blade
<!-- User item -->
<div class="p-2 md:p-3">
    <!-- Avatar size -->
    <div class="w-8 h-8 md:w-10 md:h-10">...</div>
    
    <!-- Username truncated -->
    <p class="text-sm md:text-base truncate">...</p>
    
    <!-- Subtitle hidden di mobile -->
    <p class="hidden sm:block">Click to chat</p>
</div>
```

### 4. Input Area
```blade
<!-- Form spacing -->
<form class="space-x-1 md:space-x-2">
    <!-- Icon button -->
    <label class="p-1.5 md:p-2">
        <svg class="w-5 h-5 md:w-6 md:h-6">...</svg>
    </label>
    
    <!-- Textarea -->
    <textarea class="px-3 py-2 md:px-4 text-sm md:text-base">
    
    <!-- Send button -->
    <button class="p-2 md:p-3">
        <svg class="w-5 h-5 md:w-6 md:h-6">...</svg>
    </button>
</form>
```

## Mobile Menu Implementation

### JavaScript Toggle
```javascript
function toggleMobileMenu() {
    const sidebar = document.getElementById('mobile-sidebar');
    const overlay = document.getElementById('mobile-overlay');
    
    sidebar.classList.toggle('-translate-x-full');
    overlay.classList.toggle('hidden');
}
```

### Auto-close on Action
```javascript
// Close menu saat start private chat
Livewire.on('startPrivateChat', () => {
    if (window.innerWidth < 768) {
        toggleMobileMenu();
    }
});
```

## CSS Classes Reference

### Visibility Controls
- `hidden md:block` - Hidden mobile, visible tablet+
- `md:hidden` - Visible mobile, hidden tablet+
- `hidden sm:block` - Hidden mobile, visible small+

### Sizing
- `w-8 md:w-10` - 8 mobile, 10 tablet+
- `text-sm md:text-base` - Small mobile, base tablet+
- `p-2 md:p-3` - Padding 2 mobile, 3 tablet+

### Width Control
- `max-w-[85%] sm:max-w-sm md:max-w-md` - Progressive max-width
- `w-80 md:w-64 lg:w-80` - Sidebar width per breakpoint

### Flexbox
- `space-x-1 md:space-x-2` - Gap 1 mobile, 2 tablet+
- `space-y-1.5 md:space-y-2` - Vertical gap responsive

## Testing Checklist

### Mobile (< 768px)
- [ ] Hamburger menu berfungsi
- [ ] Sidebar slide dari kiri
- [ ] Overlay muncul & clickable
- [ ] Text tidak overflow
- [ ] Buttons mudah di-tap
- [ ] Input area pas di screen
- [ ] Auto-close saat pilih user
- [ ] Scroll smooth di chat area

### Tablet (768px - 1024px)
- [ ] Sidebar visible & fixed
- [ ] No hamburger menu
- [ ] Layout balanced
- [ ] All text visible
- [ ] Comfortable spacing

### Desktop (> 1024px)
- [ ] Full width sidebar
- [ ] Optimal spacing
- [ ] No text truncation
- [ ] Hover effects work
- [ ] Large hit areas

## Performance Tips

1. **Use CSS transforms** untuk animations (translate, not left/right)
2. **Hardware acceleration** dengan transform3d
3. **Minimize reflows** dengan fixed measurements
4. **Lazy load** images di chat history
5. **Virtual scrolling** untuk long message lists (future)

## Browser Support

- ✅ Chrome 90+
- ✅ Firefox 88+
- ✅ Safari 14+
- ✅ Edge 90+
- ✅ Mobile browsers (iOS Safari, Chrome Mobile)

## Accessibility

- Touch targets minimum **44x44px**
- Focus states visible dengan `focus:ring`
- Keyboard navigation support
- Screen reader friendly dengan semantic HTML
- Contrast ratio WCAG AA compliant

---

**Responsive design ensures EtherSay works perfectly on any device! 🚀📱💻**
