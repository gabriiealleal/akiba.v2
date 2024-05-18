import usePageName from '@/hooks/usePageName';
import DivisorDeTiposDeMaterias from '@/interfaces/private/components/materias/DivisorDeTiposDeMaterias';

const Materias = () => {
    usePageName('Materias');
    
    return (
        <>
            <DivisorDeTiposDeMaterias/>
        </>
    );
}

export default Materias;