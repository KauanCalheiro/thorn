export default {
    slots: {
        content: 'bg-muted',
        viewport: 'bg-elevated',
        item: 'my-2 rounded-md '
    },
    variants: {
        variant: {
            soft: 'text-highlighted bg-elevated',
        },
    },
    defaultVariants: {
        variant: 'soft'
    }
}